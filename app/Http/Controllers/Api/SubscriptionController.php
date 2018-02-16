<?php

namespace App\Http\Controllers\Api;

use App\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubscription;
use App\Http\Resources\SubscriptionResource;

class SubscriptionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreSubscription  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSubscription $request)
    {
        $contact = Subscription::create($request->only(['email']));
        return new SubscriptionResource($contact);
    }
}
