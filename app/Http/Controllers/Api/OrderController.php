<?php

namespace App\Http\Controllers\Api;

use Carbon;
use App\Order;
use App\Product;
use App\Customer;
use App\OrderLine;
use App\PromoCode;
use App\DiscountApply;
use App\Http\Requests\StoreOrder;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\PublicResource;

class OrderController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreOrder  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrder $request)
    {
        if ($request->has('promoCode')) {
            if ($this->validateDiscount($request) == false) {
                return $this->failDiscountValidation();
            }
        }
        $customer = Customer::updateOrCreate([
            'email' => $request->customer['email']
        ], [
            'firstName' => $request->customer['firstName'],
            'lastName' => $request->customer['lastName'],
            'phone' => $request->customer['phone'],
        ]);
        $date = Carbon\Carbon::createFromFormat('d/m/Y', $request->date);
        $date->hour = 0;
        $date->minute = 0;
        $date->second = 0;
        $order = Order::create([
            'address1' => $request->address['address1'],
            'address2' => $request->address['address2'],
            'address3' => $request->address['address3'],
            'city' => $request->address['city'],
            'zip' => $request->address['zip'],
            'date' => $date,
            'time' => $request->time,
            'customer_id' => $customer->id,
            'information' => $request->information,
        ]);
        foreach ($request->orderLines as $line) {
            $product = Product::find($line['id']);
            $order->addProduct($product, $line['quantity']);
        }
        if ($request->has('promoCode')) {
            $code = PromoCode::with('discount.items.products')->where('name', $request->promoCode)->first();
            $order->usePromoCode($code);
            foreach ($code->discount->items as $discountItem) {
                $productIds = $discountItem->products->pluck('id');
                $orderLine = OrderLine::where('order_id', $order->id)
                                        ->whereIn('product_id', $productIds)
                                        ->join('products', 'order_lines.product_id', '=', 'products.id')
                                        ->orderBy('products.price', 'asc')
                                        ->first(); // cheapest product
                if ($orderLine == null) continue;
                // dd($orderLine);
                DiscountApply::create([
                    'order_id' => $order->id,
                    'discount_item_id' => $discountItem->id,
                    'product_id' => $orderLine->product->id,
                ]);
            }
        }
        Log::notice("New order (#{$order->id}) from {$request->email}");
        return new PublicResource($order->loadMissing(
            'customer', 'lines', 'discountApplies', 'discountApplies.discountItem', 'discountApplies.product'
        ));
    }

    protected function validateDiscount($request)
    {
        $orderHasProduct = false;

        $code = PromoCode::with('discount.items.products')->where('name', $request->promoCode)->first();
        $orderProductsIds = collect($request->orderLines)->pluck('id')->all();

        $discountProductsIds = $code->discount->items->reduce(function($collection, $item) {
            return $collection->merge($item->products);
        }, collect([]))->pluck('id')->unique();

        foreach ($discountProductsIds as $discountProductId) {
            $orderHasProduct = in_array($discountProductId, $orderProductsIds);
            if ($orderHasProduct) break;
        }

        return $orderHasProduct;
    }

    protected function failDiscountValidation()
    {
        return response()->json([
            'message' => 'The given data was invalid.',
            'errors' => [
                'discount' => ['Cart should include products related to the given promotional code.']
            ]
        ], 422);
    }
}
