<?php

namespace Tests\Unit;

use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function testIsStarter()
    {
        $product1 = factory(Product::class)->create();
        $product2 = factory(Product::class)->create(['type' => 'starter']);
        $this->assertEquals($product1->type === 'starter', $product1->isStarter());
        $this->assertTrue($product2->isStarter());
    }

    public function testIsMain()
    {
        $product1 = factory(Product::class)->create();
        $product2 = factory(Product::class)->create(['type' => 'main']);
        $this->assertEquals($product1->type === 'main', $product1->isMain());
        $this->assertTrue($product2->isMain());
    }

    public function testIsDrink()
    {
        $product1 = factory(Product::class)->create();
        $product2 = factory(Product::class)->create(['type' => 'drink']);
        $this->assertEquals($product1->type === 'drink', $product1->isDrink());
        $this->assertTrue($product2->isDrink());
    }

    public function testIsSide()
    {
        $product1 = factory(Product::class)->create();
        $product2 = factory(Product::class)->create(['type' => 'side']);
        $this->assertEquals($product1->type === 'side', $product1->isSide());
        $this->assertTrue($product2->isSide());
    }
}
