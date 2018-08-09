<?php

namespace Tests\Feature\Api;

use App\Product;
use App\PromoCode;
use App\Promotion;
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
            'phone' => '0123456789'
        ];
        $address = [
            'address1' => '3 rue de Paris',
            'address2' => 'Bâtiment B, étage 4, appartement 21',
            'address3' => 'Code 0000, interphone 21',
            'city' => 'Paris',
            'zip' => '75001'
        ];
        $line1 = [ 'id' => $product1->id, 'quantity' => 2 ];
        $line2 = [ 'id' => $product2->id, 'quantity' => 3 ];
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
        $this->assertDatabaseHas('order_lines', array_merge([ 'product_id' => $product1->id, 'quantity' => 2 ], ['order_id' => $response->json()['data']['id']]));
        $this->assertDatabaseHas('order_lines', array_merge([ 'product_id' => $product2->id, 'quantity' => 3 ], ['order_id' => $response->json()['data']['id']]));
    }

    public function testStoreValidatesids()
    {
        $data = [
            'customer' => [
                'firstName' => 'Sally',
                'lastName' => 'Holman',
                'email' => 'sally@email.com',
                'phone' => '0123456789'
            ],
            'address' => [
                'address1' => '3 rue de Paris',
                'address2' => 'Bâtiment B, étage 4, appartement 21',
                'address3' => 'Code 0000, interphone 21',
                'city' => 'Paris',
                'zip' => '75001'
            ],
            'orderLines' => [
                ['id' => 76, 'quantity' => 2]
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
                'phone' => '0123456789'
            ],
            'address' => [
                'address1' => '3 rue de Paris',
                'address2' => 'Bâtiment B, étage 4, appartement 21',
                'address3' => 'Code 0000, interphone 21',
                'city' => 'Paris',
                'zip' => '75001'
            ],
            'orderLines' => [
                ['id' => $product->id, 'quantity' => 2]
            ],
            'date' => date('d/m/Y', strtotime('tomorrow')),
            'time' => '19:00',
            'information' => 'allergic to everything'
        ];
        $this->json('POST', '/api/orders', $data)->assertStatus(422);
    }

    public function testStoreValidatesAllRequiredFields()
    {
        $this->json('POST', '/api/orders', [])
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'customer.firstName' => [],
                    'customer.lastName' => [],
                    'customer.email' => [],
                    'customer.phone' => [],
                    'address.address1' => [],
                    'address.city' => [],
                    'address.zip' => [],
                    'date' => [],
                    'time' => [],
                    'orderLines' => []
                ]
            ]);
    }

    public function testCanStoreTwoOrdersWithSameEmail()
    {
        $product = factory(Product::class)->create();
        $data = [
            'customer' => [
                'firstName' => 'Sally',
                'lastName' => 'Holman',
                'email' => 'sally@email.com',
                'phone' => '0123456789'
            ],
            'address' => [
                'address1' => '3 rue de Paris',
                'address2' => 'Bâtiment B, étage 4, appartement 21',
                'address3' => 'Code 0000, interphone 21',
                'city' => 'Paris',
                'zip' => '75001'
            ],
            'orderLines' => [
                ['id' => $product->id, 'quantity' => 2]
            ],
            'date' => date('d/m/Y', strtotime('tomorrow')),
            'time' => '12:00',
            'information' => 'allergic to everything'
        ];
        $this->json('POST', '/api/orders', $data)->assertStatus(201);
        $data['time'] = '12:15';
        $data['customer']['firstName'] = 'Something';
        $data['customer']['lastName'] = 'Else';
        $data['customer']['phone'] = '0601010101';
        $this->json('POST', '/api/orders', $data)->assertStatus(201);
    }

    /** @test */
    public function it_stores_orders_with_promo_code()
    {
        $promotion = factory(Promotion::class)->create([
            'final_percentage' => 50
        ]);
        $promoCode = factory(PromoCode::class)->create([
            'name' => 'TESTCODE',
            'promotion_id' => $promotion->id
        ]);
        $product = factory(Product::class)->create();
        $data = [
            'customer' => [
                'firstName' => 'Sally',
                'lastName' => 'Holman',
                'email' => 'sally@email.com',
                'phone' => '0123456789'
            ],
            'address' => [
                'address1' => '3 rue de Paris',
                'address2' => 'Bâtiment B, étage 4, appartement 21',
                'address3' => 'Code 0000, interphone 21',
                'city' => 'Paris',
                'zip' => '75001'
            ],
            'orderLines' => [
                ['id' => $product->id, 'quantity' => 2]
            ],
            'date' => date('d/m/Y', strtotime('tomorrow')),
            'time' => '12:00',
            'information' => 'allergic to everything',
            'promoCode' => 'TESTCODE',

        ];
        $response = $this->json('POST', '/api/orders', $data)->assertStatus(201);
        $this->assertDatabaseHas('orders', [
            'id' => $response->json()['data']['id'],
            'promoCode_id' => $promoCode->id,
            'promotion_id' => $promotion->id,
        ]);
    }
}
