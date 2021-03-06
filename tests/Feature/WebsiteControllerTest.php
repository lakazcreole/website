<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WebsiteControllerTest extends TestCase
{
    public function testHome()
    {
        $this->get('/')
            ->assertStatus(200)
            ->assertViewIs('home')
            ->assertViewHas('orderUrl', route('order'));
    }
}
