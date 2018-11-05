<?php

namespace Tests\Feature;

use App\User;
use App\Discount;
use App\PromoCode;
use Tests\TestCase;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PromoCodeControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    public function setUp()
    {
        parent::setUp();
        $this->admin = factory(User::class)->create(['admin' => true]);
    }

    /** @test */
    public function index()
    {
        $this->actingAs($this->admin)
            ->get(route('dashboard.promo-codes.index'))
            ->assertStatus(200)
            ->assertViewIs('promo_codes.index')
            ->assertViewHasAll([
                'promoCodes' => PromoCode::with('discount')->get(),
                'createRoute' => 'dashboard.promo-codes.create',
                'editRoute' => 'dashboard.promo-codes.edit'
            ]);
    }

    /** @test */
    public function create()
    {
        $this->actingAs($this->admin)
            ->get(route('dashboard.promo-codes.create'))
            ->assertStatus(200)
            ->assertViewIs('promo_codes.create')
            ->assertViewHasAll([
                'discounts' => Discount::all(),
                'indexRoute' => 'dashboard.promo-codes.index',
                'storeRoute' => 'dashboard.promo-codes.store',
            ]);
    }

    /** @test */
    public function store()
    {
        $discount = factory(Discount::class)->create();
        $data = [
            'name' => 'TESTCODE',
            'maxUses' => 49,
            'discountId' => $discount->id,
            'beginAt' => '02/01/2017',
            'endAt' => '01/02/2017',
        ];
        $this->actingAs($this->admin)
            ->post(route('dashboard.promo-codes.store'), $data)
            ->assertRedirect(route('dashboard.promo-codes.index'))
            ->assertSessionHas('success', "Le code promotionnel {$data['name']} a été créé.");
        $this->assertDatabaseHas('promo_codes', [
            'name' => $data['name'],
            'uses' => 0,
            'max_uses' => $data['maxUses'],
            'discount_id' => $data['discountId'],
            'begin_at' => Carbon::createFromFormat('d/m/Y', $data['beginAt'])->startOfDay(),
            'end_at' => Carbon::createFromFormat('d/m/Y', $data['endAt'])->startOfDay()
        ]);
    }

    /** @test */
    public function edit()
    {
        $promoCode = factory(PromoCode::class)->create([
            'discount_id' => factory(Discount::class)->create()->id,
        ]);
        $this->actingAs($this->admin)
            ->get(route('dashboard.promo-codes.edit', ['promoCode' => $promoCode]))
            ->assertStatus(200)
            ->assertViewIs('promo_codes.edit')
            ->assertViewHasAll([
                'id' => $promoCode->id,
                'name' => $promoCode->name,
                'uses' => $promoCode->uses,
                'maxUses' => $promoCode->max_uses,
                'discountId' => $promoCode->discount_id,
                'beginAt' => $promoCode->begin_at,
                'endAt' => $promoCode->end_at,
                'discounts' =>  Discount::all(),
                'indexRoute' => 'dashboard.promo-codes.index',
                'updateRoute' => 'dashboard.promo-codes.update',
                'destroyRoute' => 'dashboard.promo-codes.destroy',
                'routeParameter' => 'promo-code'
            ]);
    }

    /** @test */
    public function update()
    {
        $promoCode = factory(PromoCode::class)->create([
            'discount_id' => factory(Discount::class)->create()->id,
        ]);
        $discount = factory(Discount::class)->create();
        $data = [
            'name' => 'TESTCODE',
            'maxUses' => 49,
            'discountId' => $discount->id,
            'beginAt' => '02/01/2017',
            'endAt' => '01/02/2017',
        ];
        $this->actingAs($this->admin)
            ->put(route('dashboard.promo-codes.update', ['promoCode' => $promoCode]), $data)
            ->assertRedirect(route('dashboard.promo-codes.index'))
            ->assertSessionHas('success', "Le code promotionnel {$data['name']} a été modifié.");
        $this->assertDatabaseHas('promo_codes', [
            'id' => $promoCode->id,
            'name' => $data['name'],
            'uses' => $promoCode->uses,
            'max_uses' => $data['maxUses'],
            'discount_id' => $data['discountId'],
            'begin_at' => Carbon::createFromFormat('d/m/Y', $data['beginAt'])->startOfDay(),
            'end_at' => Carbon::createFromFormat('d/m/Y', $data['endAt'])->startOfDay()
        ]);
    }

    /** @test */
    public function destroy()
    {
        $promoCode = factory(PromoCode::class)->create([
            'discount_id' => factory(Discount::class)->create()->id,
        ]);
        $this->actingAs($this->admin)
            ->delete(route('dashboard.promo-codes.destroy', ['promoCode' => $promoCode]))
            ->assertRedirect(route('dashboard.promo-codes.index'))
            ->assertSessionHas('success', "Le code promotionnel {$promoCode->name} a été supprimé avec succès !");
        $this->assertDatabaseMissing('promo_codes', ['id' => $promoCode->id]);
    }
}
