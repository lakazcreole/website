<?php

namespace App;

use App\Customer;
use App\OrderLine;
use App\Promotion;
use Carbon\Carbon;
use App\Events\OrderCreated;
use App\Events\OrderAccepted;
use App\Events\OrderDeclined;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'address1', 'address2', 'address3', 'city', 'zip', 'date', 'time', 'information', 'customer_id'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'date',
        'created_at',
        'updated_at',
        'deleted_at',
        'canceled_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'notifyAccept' => 'boolean',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => OrderCreated::class,
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function lines()
    {
        return $this->hasMany(OrderLine::class, 'order_id');
    }

    public function addProduct(Product $product, $quantity = 1)
    {
        $this->lines()->save(OrderLine::create([
            'product_id' => $product->id,
            'order_id' => $this->id,
            'quantity' => $quantity,
            'totalPrice' => $quantity *  $product->price,
        ]));
    }

    public function getAcceptUrlAttribute()
    {
        return action('OrderController@getAcceptForm', ['order' => $this->id]);
    }

    public function getDeclineUrlAttribute()
    {
        return action('OrderController@getDeclineForm', ['order' => $this->id]);
    }

    public function getTotalProductsPriceAttribute()
    {
        if (!$this->relationLoaded('lines'))
        {
            $this->load('lines');
        }
        return $this->lines->sum('totalPrice');
    }

    public function getDeliveryPriceAttribute()
    {
        if ($this->totalProductsPrice < 13)
            return 2;
        if ($this->totalProductsPrice >= 15)
            return 0;
        return 15 - $this->totalProductsPrice;
    }

    public function getPriceBeforePromotionAttribute()
    {
        return $this->totalProductsPrice + $this->deliveryPrice;
    }

    public function getFinalPriceAttribute()
    {
        return $this->priceBeforePromotion;
    }

    public function accept($message)
    {
        $this->accepted_at = Carbon::now();
        $this->acceptMessage = $message;
        $this->save();
        event(new OrderAccepted($this));
    }

    public function decline($message)
    {
        $this->declined_at = Carbon::now();
        $this->declineMessage = $message;
        $this->save();
        event(new OrderDeclined($this));
    }

    public function cancel()
    {
        $this->canceled_at = Carbon::now();
        $this->save();
    }

    public function isAccepted()
    {
        return $this->accepted_at !== null;
    }

    public function isDeclined()
    {
        return $this->declined_at !== null;
    }

    public function isCanceled()
    {
        return $this->canceled_at !== null;
    }

    public function isWaiting()
    {
        return $this->accepted_at === null && $this->declined_at === null && $this->canceled_at === null;
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class, 'promotion_id');
    }

    public function apply(Promotion $promo)
    {
        $this->promotion()->associate($promo);
        $this->save();
    }

    public function getDiscountAttribute()
    {
        if ($this->promotion)
        {
            return $this->promotion->generateDiscount($this->lines, $this->deliveryPrice);
        }
        return 0;
    }
}
