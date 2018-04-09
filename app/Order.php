<?php

namespace App;

use App\Customer;
use App\OrderLine;
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

    public function getTotalPriceAttribute()
    {
        $this->load('lines');
        return $this->lines->sum('totalPrice');
    }

    public function getAcceptUrlAttribute()
    {
        return action('OrderController@accept', ['order' => $this->id]);
    }

    public function getDeclineUrlAttribute()
    {
        return action('OrderController@getDeclineForm', ['order' => $this->id]);
    }

    public function accept()
    {
        $this->accepted_at = Carbon::now();
        $this->save();
        event(new OrderAccepted($this));
    }

    public function isAccepted()
    {
        return $this->accepted_at !== null;
    }

    public function isDeclined()
    {
        return $this->declined_at !== null;
    }

    public function decline($message)
    {
        $this->declined_at = Carbon::now();
        $this->declineMessage = $message;
        $this->save();
        event(new OrderDeclined($this));
    }
}
