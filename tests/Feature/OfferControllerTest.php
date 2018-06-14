<?php

namespace Tests\Feature;

use App\User;
use App\Offer;
use App\Product;
use Tests\TestCase;
use Illuminate\Support\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OfferControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $productTypes = [
        [ 'type' => 'starter', 'title' => 'Entrées' ],
        [ 'type' => 'main', 'title' => 'Plats' ],
        [ 'type' => 'drink', 'title' => 'Boissons' ],
        [ 'type' => 'side', 'title' => 'Accompagnements' ],
    ];

    protected $admin;

    public function setUp()
    {
        parent::setUp();
        $this->admin = factory(User::class)->create(['admin' => true]);
    }

    public function testIndex()
    {
        $this->actingAs($this->admin)
            ->get(route('dashboard.offers.index'))
            ->assertStatus(200)
            ->assertViewIs('offers.index')
            ->assertViewHas('offers', Offer::all());
    }

    public function testCreate()
    {
        $this->actingAs($this->admin)
            ->get(route('dashboard.offers.create'))
            ->assertStatus(200)
            ->assertViewIs('offers.create')
            ->assertViewHas('products', Product::all())
            ->assertViewHas('productTypes', $this->productTypes);
    }

    public function testStore()
    {
        Storage::fake();
        $data = [
            'name' => 'Something interesting',
            'product' => factory(Product::class)->create()->id,
            'begin_date' => '02/01/2017',
            'end_date' => '01/02/2017',
            'enabled' => true,
            'image' => UploadedFile::fake()->image('image.jpg')
        ];
        $this->actingAs($this->admin)
            ->post(route('dashboard.offers.store'), $data)
            ->assertRedirect(route('dashboard.offers.index'))
            ->assertSessionHas('success', "L'offre {$data['name']} a été créé avec succès !");
        $this->assertDatabaseHas('offers', [
            'name' => $data['name'],
            'product_id' => $data['product'],
            'begin_at' => Carbon::createFromFormat('d/m/Y', $data['begin_date'])->startOfDay(),
            'end_at' => Carbon::createFromFormat('d/m/Y', $data['end_date'])->startOfDay(),
            'enabled' => $data['enabled'],
        ]);
        $imageUrl = Offer::findByName('Something interesting')->imageUrl;
        Storage::disk('local')->assertExists("public/{$imageUrl}");
    }

    public function testStoreValidatesData()
    {
        $this->actingAs($this->admin)
            ->post(route('dashboard.offers.store'), [])
            ->assertStatus(302)
            ->assertSessionHasErrors(['name', 'product', 'begin_date', 'end_date', 'enabled', 'image']);
    }

    public function testEdit()
    {
        $offer = factory(Offer::class)->create(['product_id' => factory(Product::class)->create()->id]);
        $this->actingAs($this->admin)
            ->get(route('dashboard.offers.edit', ['offer' => $offer]))
            ->assertStatus(200)
            ->assertViewIs('offers.edit')
            ->assertViewHas('id', $offer->id)
            ->assertViewHas('name', $offer->name)
            ->assertViewHas('product', $offer->product_id)
            ->assertViewHas('begin_date', $offer->begin_at)
            ->assertViewHas('end_date', $offer->end_at)
            ->assertViewHas('enabled', $offer->enabled)
            ->assertViewHas('imageUrl', $offer->imageUrl)
            ->assertViewHas('products', Product::all())
            ->assertViewHas('productTypes', $this->productTypes);
    }

    public function testUpdate()
    {
        Storage::fake();
        $offer = factory(Offer::class)->create(['product_id' => factory(Product::class)->create()->id]);
        $data = [
            'name' => 'Something new',
            'product' => factory(Product::class)->create()->id,
            'begin_date' => '02/01/2017',
            'end_date' => '01/02/2017',
            'enabled' => true,
            'image' => UploadedFile::fake()->image('image.jpg'),
        ];

        $this->actingAs($this->admin)
            ->post(route('dashboard.offers.update', ['offer' => $offer]), $data)
            ->assertRedirect(route('dashboard.offers.index'))
            ->assertSessionHas('success', "L'offre {$data['name']} a été modifiée avec succès !");
        $this->assertDatabaseHas('offers', [
            'name' => $data['name'],
            'product_id' => $data['product'],
            'begin_at' => Carbon::createFromFormat('d/m/Y', $data['begin_date'])->startOfDay(),
            'end_at' => Carbon::createFromFormat('d/m/Y', $data['end_date'])->startOfDay(),
            'enabled' => $data['enabled']
        ]);
        $imageUrl = Offer::find($offer->id)->imageUrl;
        Storage::disk('local')->assertExists("public/{$imageUrl}");
    }

    public function testUpdateValidatesData()
    {
        $offer = factory(Offer::class)->create(['product_id' => factory(Product::class)->create()->id]);
        $this->actingAs($this->admin)
            ->post(route('dashboard.offers.update', ['offer' => $offer]), [])
            ->assertStatus(302)
            ->assertSessionHasErrors(['name', 'product', 'begin_date', 'end_date', 'enabled']);
    }

    public function testDestroy()
    {
        $offer = factory(Offer::class)->create(['product_id' => factory(Product::class)->create()->id]);
        $this->actingAs($this->admin)
            ->get(route('dashboard.offers.destroy', ['offer' => $offer]))
            ->assertRedirect(route('dashboard.offers.index'))
            ->assertSessionHas('success', "L'offre {$offer->name} a été supprimée avec succès !");
        $this->assertDatabaseMissing('offers', ['id' => $offer->id]);
    }
}
