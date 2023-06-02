<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProductBookmarkTest extends TestCase
{
    public function test_bookmark_product_successfully()
    {
        $user = $this->_getUser('User');
        $data = [
            'title' => $this->faker->words(rand(5, 12), true),
            'details' => $this->faker->paragraph(),
        ];
        $product = Product::create($data);
        $payload = [
            'type' => 'save',
        ];
        $this->actingAs($user, 'sanctum')
            ->json('post', "api/product/bookmark/{$product->id}", $payload)
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson(
                [
                    'message' => "Product Bookmarked Successfully!!!",
                    'product' => [
                        'id' => $product->id,
                        'title' => $product->title,
                        'details' => $product->details,
                        'created_at' => $product->created_at,
                        'updated_at' => $product->updated_at,
                        'bookmark' => true,
                    ],
                ]
            );
        $this->assertDatabaseHas('product_bookmarks', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }
}
