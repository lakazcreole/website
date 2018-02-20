<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FrontEndControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testHome()
    {
        $this->get('/')
            ->assertStatus(200)
            ->assertViewIs('home');
    }

    public function testOrder()
    {
        $this->get('/commande')
            ->assertStatus(200)
            ->assertViewIs('orders.create');
    }
}
