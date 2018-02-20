<?php

namespace Tests\Unit;

use App\Customer;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerTest extends TestCase
{
    public function testFirstNameIsCapitalized()
    {
        $customer = factory(Customer::class)->make(['firstName' => 'john']);
        $this->assertEquals('John', $customer->firstName);
    }
}
