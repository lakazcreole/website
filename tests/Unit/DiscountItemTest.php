<?php

namespace Tests\Unit;

use App\Product;
use App\Discount;
use Tests\TestCase;
use App\DiscountItem;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DiscountItemTest extends TestCase
{
    use RefreshDatabase;

    protected $discount;

    public function setUp()
    {
        parent::setUp();
        $this->discount = factory(Discount::class)->create();
    }

    /** @test */
    public function it_has_a_products_relationship()
    {
        $product = factory(Product::class)->create();
        $discountItem = factory(DiscountItem::class)->create(['discount_id' => $this->discount]);
        $discountItem->products()->attach($product->id);
        $this->assertEquals(1, $discountItem->products->count());
        $this->assertEquals($product->id, $discountItem->products->first()->id);
    }
}
