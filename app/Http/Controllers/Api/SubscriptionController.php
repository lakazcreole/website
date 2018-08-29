<?php

namespace App\Http\Controllers\Api;

use App\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
        $contact = Subscription::updateOrCreate($request->only(['email']));
        Log::notice("New subscription (#{$contact->id}) from {$request->email}");
        return new SubscriptionResource($contact);
    }
}
