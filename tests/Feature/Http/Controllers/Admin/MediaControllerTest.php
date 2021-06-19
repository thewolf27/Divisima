<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\Image;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class MediaControllerTest extends TestCase
{
    use WithoutMiddleware;
    use DatabaseTransactions;

//    public function testUploadImage()
//    {
//        Storage::fake('images');
//
//        $file = UploadedFile::fake()->image('image.jpg');
//
//        $images = [
//            $file,
//        ];
//
//        $response = $this->post(route('upload-image'), [
//            'image' => $images,
//        ]);
//
//        $response->assertStatus(401);
//
//        $user = User::admin();
//
//        $response = $this->actingAs($user)
//                            ->post(route('upload-image'), [
//                                'image' => $images,
//                            ]);
//
//        $response->assertOk();
//    }

    public function testDeleteImages()
    {
        $image = Image::factory()->create();
        $user = User::admin();

        $response = $this->actingAs($user)
            ->delete(route('deleteImages'), [
                'ids' => [$image->id],
            ]);

        $response->assertOk();
        $this->assertDeleted('images', [
            'id' => $image->id,
        ]);
    }

    public function testLoadGallery()
    {
        $gallery = Image::factory()->count(4)->create()->pluck('id')->toArray();
        $user = User::admin();

        $response = $this->actingAs($user)
            ->get(route('loadGallery', [
                'gallery' => $gallery,
            ]));

        $response->assertSee('gallery-img');
        $response->assertOk();
    }

    public function testLoadMediaImages()
    {
        $user = User::admin();

        $response = $this->actingAs($user)
            ->get(route('loadMediaImages'));

        $response->assertSee('media-img');
        $response->assertOk();
    }
}