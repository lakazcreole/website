<?php

namespace App\Http\Controllers\Api;

use App\Contact;
use Illuminate\Http\Request;
use App\Events\ContactCreated;
use App\Http\Requests\StoreContact;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\ContactResource;

class ContactController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreContact  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContact $request)
    {
        $contact = Contact::create($request->only(['name', 'email', 'subject', 'message']));
        Log::notice("New contact (#{$contact->id}) from {$request->name}");
        return new ContactResource($contact);
    }
}
