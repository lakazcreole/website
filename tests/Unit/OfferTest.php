<?php

namespace Tests\Unit;

use App\Offer;
use App\Product;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OfferTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_hides_the_name_in_json_serialization()
    {
        $offer = factory(Offer::class)->make();
        $this->assertFalse(array_key_exists('name', $offer->toArray()));
    }

    /** @test */
    public function it_can_be_found_by_name()
    {
        $this->assertEquals(Offer::where('name', 'Something')->first(), Offer::findByName('Something'));
        $offer = factory(Offer::class)->create([
            'name' => 'Something',
            'product_id' => factory(Product::class)->create()->id
        ]);
        $this->assertEquals($offer->id, Offer::findByName('Something')->id);
    }

    /** @test */
    public function it_casts_enabled_attribute_to_boolean()
    {
        $p = factory(Product::class)->create();
        $offer1 = factory(Offer::class)->create(['enabled' => true, 'product_id' => $p->id]);
        $offer2 = factory(Offer::class)->create(['enabled' => false, 'product_id' => $p->id]);
        $offer1 = Offer::find($offer1->id);
        $offer2 = Offer::find($offer2->id);
        $this->assertTrue($offer1->enabled === true);
        $this->assertTrue($offer2->enabled === false);
    }

    /** @test */
    public function save_image_updates_attribute()
    {
        Storage::fake();
        $offer = factory(Offer::class)->create([
            'name' => 'Something',
            'product_id' => factory(Product::class)->create()->id
        ]);
        $offer->saveImage(UploadedFile::fake()->image('image.jpg'));
        $this->assertTrue(strpos(Offer::find($offer->id)->imageUrl, 'storage/') === 0); // starts with 'storage/'
    }
}
