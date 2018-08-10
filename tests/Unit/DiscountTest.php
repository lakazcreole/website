<?php

namespace Tests\Unit;

use App\Product;
use App\Discount;
use App\PromoCode;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DiscountTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_an_add_product_method()
    {
        $product = factory(Product::class)->create();
        $product2 = factory(Product::class)->create();
        $discount = factory(Discount::class)->create();
        $discount->addProduct($product, 100);
        $discount->addProduct($product2, 20, false);
        $this->assertDatabaseHas('discount_product', [
            'discount_id' => $discount->id,
            'product_id' => $product->id,
            'percent' => 100,
            'required' => true
        ]);
        $this->assertDatabaseHas('discount_product', [
            'discount_id' => $discount->id,
            'product_id' => $product2->id,
            'percent' => 20,
            'required' => false
        ]);
    }

    /** @test */
    public function it_has_an_add_free_product_method()
    {
        $product = factory(Product::class)->create();
        $discount = factory(Discount::class)->create();
        $discount->addFreeProduct($product, false);
        $this->assertDatabaseHas('discount_product', [
            'discount_id' => $discount->id,
            'product_id' => $product->id,
            'percent' => 100,
            'required' => false
        ]);
    }

    /** @test */
    public function it_has_a_value_attribute()
    {
        $product = factory(Product::class)->create(['price' => 15]);
        $discount = factory(Discount::class)->create();
        $discount->addProduct($product, 100);
        $discount->addProduct($product, 50);
        $this->assertEquals(15 + 7.5, $discount->value);
    }

    /** @test */
    public function it_has_required_products_attribute()
    {
        $requiredProduct = factory(Product::class)->create();
        $notRequiredProduct = factory(Product::class)->create();
        $discount = factory(Discount::class)->create();
        $discount->addProduct($requiredProduct, 100, true);
        $discount->addProduct($notRequiredProduct, 100, false);
        $this->assertTrue($discount->requiredProducts->contains($requiredProduct));
        $this->assertFalse($discount->requiredProducts->contains($notRequiredProduct));
    }

    /** @test */
    public function it_can_have_many_promo_codes()
    {
        $discount = factory(Discount::class)->create();
        $codes = factory(PromoCode::class, 5)->create(['discount_id' => $discount->id]);
        $this->assertEquals(5, $discount->promoCodes->count());
    }
}
