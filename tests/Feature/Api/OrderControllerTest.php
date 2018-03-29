<?php

namespace Tests\Feature\Api;

use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testStore()
    {
        $product1 = factory(Product::class)->create();
        $product2 = factory(Product::class)->create();
        $customer = [
            'firstName' => 'Sally',
            'lastName' => 'Holman',
            'email' => 'sally@email.com',
            'phone' => '01 23 45 67 89'
        ];
        $address = [
            'address1' => '3 rue de Paris',
            'address2' => 'Bâtiment B, étage 4, appartement 21',
            'address3' => 'Code 0000, interphone 21',
            'city' => 'Paris',
            'zip' => '75001'
        ];
        $line1 = [ 'product_id' => $product1->id, 'quantity' => 2 ];
        $line2 = [ 'product_id' => $product2->id, 'quantity' => 3 ];
        $data = [
            'customer' => $customer,
            'address' => $address,
            'orderLines' => [ $line1, $line2 ],
            'date' => date('d/m/Y', strtotime('tomorrow')),
            'time' => '13:00',
            'information' => 'allergic to everything'
        ];
        $response = $this->json('POST', '/api/orders', $data);
        $response->assertStatus(201);
        $this->assertDatabaseHas('orders', $address);
        $this->assertDatabaseHas('customers', $customer);
        $this->assertDatabaseHas('order_lines', array_merge($line1, ['order_id' => $response->json()['data']['id']]));
        $this->assertDatabaseHas('order_lines', array_merge($line2, ['order_id' => $response->json()['data']['id']]));
    }

    public function testStoreValidatesProductIds()
    {
        $data = [
            'customer' => [
                'firstName' => 'Sally',
                'lastName' => 'Holman',
                'email' => 'sally@email.com',
                'phone' => '01 23 45 67 89'
            ],
            'address' => [
                'address1' => '3 rue de Paris',
                'address2' => 'Bâtiment B, étage 4, appartement 21',
                'address3' => 'Code 0000, interphone 21',
                'city' => 'Paris',
                'zip' => '75001'
            ],
            'orderLines' => [
                ['product_id' => 76, 'quantity' => 2]
            ],
            'date' => date('d/m/Y', strtotime('tomorrow')),
            'time' => '13:00',
            'information' => 'allergic to everything'
        ];
        $response = $this->json('POST', '/api/orders', $data)->assertStatus(422);
    }

    public function testStoreValidatesFields()
    {
        $this->json('POST', '/api/orders', [])->assertStatus(422);
        $this->json('POST', '/api/orders', ['customer' => [], 'address' => [], 'orderLines' => []])->assertStatus(422);
    }

    public function testStoreValidatesDeliveryHours()
    {
        $product = factory(Product::class)->create();
        $data = [
            'customer' => [
                'firstName' => 'Sally',
                'lastName' => 'Holman',
                'email' => 'sally@email.com',
                'phone' => '01 23 45 67 89'
            ],
            'address' => [
                'address1' => '3 rue de Paris',
                'address2' => 'Bâtiment B, étage 4, appartement 21',
                'address3' => 'Code 0000, interphone 21',
                'city' => 'Paris',
                'zip' => '75001'
            ],
            'orderLines' => [
                ['product_id' => $product->id, 'quantity' => 2]
            ],
            'date' => date('d/m/Y', strtotime('tomorrow')),
            'time' => '16:00',
            'information' => 'allergic to everything'
        ];
        $this->json('POST', '/api/orders', $data)->assertStatus(422);
    }
}
