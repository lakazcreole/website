<?php

namespace App;

use App\Customer;
use App\OrderLine;
use App\PromoCode;
use Carbon\Carbon;
use App\DiscountApply;
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
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'address',
        'customer',
        'date', 'time',
        'information',
        'lines',
        'total_products_price', 'delivery_price', 'final_price',
        'discount', 'discountApplies'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'address',
        'total_products_price', 'delivery_price', 'final_price',
        'discount',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
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
        'date' => 'date:Y-m-d',
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

    public function promoCode()
    {
        return $this->belongsTo(PromoCode::class, 'promo_code_id');
    }

    public function discountApplies()
    {
        return $this->hasMany(DiscountApply::class);
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

    public function usePromoCode(PromoCode $code)
    {
        $this->promoCode()->associate($code);
        $this->save();
        $code->uses++;
        $code->save();
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

    public function getAcceptUrlAttribute()
    {
        return action('OrderController@getAcceptForm', ['order' => $this->id]);
    }

    public function getDeclineUrlAttribute()
    {
        return action('OrderController@getDeclineForm', ['order' => $this->id]);
    }

    public function getAddressAttribute()
    {
        return [
            'address1' => $this->address1,
            'address2' => $this->address2,
            'address3' => $this->address3,
            'city' => $this->city,
            'zip' => $this->zip,
        ];
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

    public function getPriceBeforeDiscountAttribute()
    {
        return $this->totalProductsPrice + $this->deliveryPrice;
    }

    public function getFinalPriceAttribute()
    {
        if ($this->promoCode)
        {
            $applies = DiscountApply::with('product')->where('order_id', $this->id)->get();
            $discountValue = 0;
            foreach ($applies as $discountApply) {
                $discountValue += $discountApply->product->price * $discountApply->discountItem->percent / 100;
                Log::debug($discountValue);
            }
            return $this->priceBeforeDiscount - $discountValue;
        }
        return $this->priceBeforeDiscount;
    }

    public function getDiscountAttribute()
    {
        return $this->promoCode ? $this->promoCode->discount->makeHidden('items') : null;
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
}
