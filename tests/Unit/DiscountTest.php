<?php

namespace Tests\Unit;

use App\Product;
use App\Discount;
use App\PromoCode;
use Tests\TestCase;
use App\DiscountItem;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DiscountTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_be_found_by_name()
    {
        $discount = factory(Discount::class)->create(['name' => 'TEST']);
        $this->assertEquals($discount->id, Discount::findByName('TEST')->id);
    }

    /** @test */
    public function it_can_have_many_promo_codes()
    {
        $discount = factory(Discount::class)->create();
        $codes = factory(PromoCode::class, 5)->create(['discount_id' => $discount->id]);
        $this->assertEquals(5, $discount->promoCodes->count());
    }

    /** @test */
    public function it_has_discount_items()
    {
        $discount = factory(Discount::class)->create();
        $this->assertEquals(0, $discount->items->count());
    }

    /** @test */
    public function it_has_required_items()
    {
        $discount = factory(Discount::class)->create();
        factory(DiscountItem::class, 3)->create(['discount_id' => $discount->id, 'required' => false]);
        factory(DiscountItem::class, 3)->create(['discount_id' => $discount->id, 'required' => true]);
        $requiredItems = $discount->items->filter(function ($item) {
            return $item->required;
        });
        $this->assertEquals($requiredItems, $discount->requiredItems);
    }
}
