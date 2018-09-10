<?php

namespace Tests\Feature\Api;

use App\Product;
use App\Discount;
use App\PromoCode;
use Tests\TestCase;
use App\DiscountItem;
use App\DiscountApply;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderControllerStoreTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_stores_order_customer_and_order_lines()
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

    /** @test */
    public function it_validates_product_ids()
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

    /** @test */
    public function it_validates_fields_presence()
    {
        $this->json('POST', '/api/orders', [])->assertStatus(422);
        $this->json('POST', '/api/orders', ['customer' => [], 'address' => [], 'orderLines' => []])->assertStatus(422);
    }

    /** @test */
    public function it_validates_all_required_fields()
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

    /** @test */
    public function it_validates_delivery_hours()
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

    /** @test */
    public function it_accepts_orders_with_same_email()
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
    public function it_stores_orders_with_discount()
    {
        $product = factory(Product::class)->create();
        $discount = factory(Discount::class)->create();
        $discountItem = factory(DiscountItem::class)->create(['discount_id' => $discount->id]);
        $discountItem->products()->attach($product->id);
        $promoCode = factory(PromoCode::class)->create([
            'name' => 'TESTCODE',
            'discount_id' => $discount->id
        ]);
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
            'promoCode' => $promoCode->name,
            'date' => date('d/m/Y', strtotime('tomorrow')),
            'time' => '12:00',
            'information' => 'allergic to everything',

        ];
        $response = $this->json('POST', '/api/orders', $data)->assertStatus(201);
        // Order is stored
        $this->assertDatabaseHas('orders', [
            'id' => $response->json()['data']['id'],
            'promo_code_id' => $promoCode->id,
        ]);
        // Discount is applied
        $this->assertDatabaseHas('discount_applies', [
            'order_id' => $response->json()['data']['id'],
            'discount_item_id' => $discountItem->id,
            'product_id' => $product->id,
        ]);
        $this->assertEquals(1, DiscountApply::count());
        // PromoCode is updated
        $this->assertDatabaseHas('promo_codes', [
            'id' => $promoCode->id,
            'uses' => 1,
        ]);
    }

    /** @test */
    public function it_applies_discount_on_the_cheapest_product()
    {
        $product = factory(Product::class)->create(['price' => 15]);
        $product2 = factory(Product::class)->create(['price' => 5]);
        $discount = factory(Discount::class)->create();
        $discountItem = factory(DiscountItem::class)->create(['discount_id' => $discount->id]);
        $discountItem->products()->attach([$product->id, $product2->id]);
        $promoCode = factory(PromoCode::class)->create([
            'name' => 'TESTCODE',
            'discount_id' => $discount->id
        ]);
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
                ['id' => $product->id, 'quantity' => 2],
                ['id' => $product2->id, 'quantity' => 2]
            ],
            'promoCode' => $promoCode->name,
            'date' => date('d/m/Y', strtotime('tomorrow')),
            'time' => '12:00',
            'information' => 'allergic to everything',
        ];
        $response = $this->json('POST', '/api/orders', $data)->assertStatus(201);
        // Discount is applied
        $this->assertDatabaseHas('discount_applies', [
            'order_id' => $response->json()['data']['id'],
            'discount_item_id' => $discountItem->id,
            'product_id' => $product2->id,
        ]);
        $this->assertEquals(1, DiscountApply::count());
    }

    /** @test */
    public function single_item_discount_requires_product_to_be_applied()
    {
        $product = factory(Product::class)->create();
        $product2 = factory(Product::class)->create();
        $product3 = factory(Product::class)->create();
        $discount = factory(Discount::class)->create();
        $discountItem = factory(DiscountItem::class)->create(['discount_id' => $discount->id]);
        $discountItem->products()->attach([$product->id, $product2->id]);
        $promoCode = factory(PromoCode::class)->create([
            'name' => 'TESTCODE',
            'discount_id' => $discount->id
        ]);
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
                ['id' => $product3->id, 'quantity' => 2]
            ],
            'promoCode' => $promoCode->name,
            'date' => date('d/m/Y', strtotime('tomorrow')),
            'time' => '12:00',
            'information' => 'allergic to everything',
        ];
        $this->json('POST', '/api/orders', $data)
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'discount' => [
                        'Cart should include products related to the given promotional code.'
                    ]
                ]
            ]);
    }

    /** @test */
    public function multiple_items_discount_requires_at_least_one_product_to_be_applied()
    {
        $product = factory(Product::class)->create();
        $product2 = factory(Product::class)->create();
        $product3 = factory(Product::class)->create();
        $discount = factory(Discount::class)->create();
        $discountItem = factory(DiscountItem::class)->create(['discount_id' => $discount->id]);
        $discountItem->products()->attach([$product2->id, $product3->id]);
        $discountItem2 = factory(DiscountItem::class)->create(['discount_id' => $discount->id]);
        $discountItem2->products()->attach([$product2->id, $product3->id]);
        $promoCode = factory(PromoCode::class)->create([
            'name' => 'TESTCODE',
            'discount_id' => $discount->id
        ]);
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
            'promoCode' => $promoCode->name,
            'date' => date('d/m/Y', strtotime('tomorrow')),
            'time' => '12:00',
            'information' => 'allergic to everything',
        ];
        $this->json('POST', '/api/orders', $data)
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'discount' => [
                        'Cart should include products related to the given promotional code.'
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_validates_promo_code_when_present()
    {
        $this->json('POST', '/api/orders', [
            'promoCode' => 'FAKECODE'
        ])
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'promoCode' => []
                ]
            ]);
    }
}
