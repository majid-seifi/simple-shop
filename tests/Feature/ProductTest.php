<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function test_index_returns_data_in_valid_format()
    {
        Product::factory()->count(50)->create();
        $this->json('get', 'api/product?page=' . rand(1, 5))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(
                [
                    'data' => [
                        '*' => [
                            'id',
                            'title',
                        ],
                    ],
                ]
            );
    }

    public function test_store_product_successfully()
    {
        $user = $this->_getUser();
        $payload = [
            'title' => $this->faker->words(rand(5, 12), true),
            'details' => $this->faker->paragraph(),
        ];
        $this->actingAs($user, 'sanctum')
            ->json('post', 'api/product', $payload)
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(
                [
                    'message',
                    'product' => [
                        'id',
                        'title',
                        'details',
                        'created_at',
                        'updated_at',
                    ]
                ]
            );
        $this->assertDatabaseHas('products', $payload);
    }

    public function test_show_returns_valid_data()
    {
        $user = $this->_getUser();
        $data = [
            'title' => $this->faker->words(rand(5, 12), true),
            'details' => $this->faker->paragraph(),
        ];
        $product = Product::create($data);
        $this->actingAs($user, 'sanctum')
            ->json('get', "api/product/{$product->id}")
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(
                [
                    'id',
                    'title',
                    'bookmark',
                ]
            );
    }

    public function test_update_product_successfully()
    {
        $user = $this->_getUser();
        $data = [
            'title' => $this->faker->words(rand(5, 12), true),
            'details' => $this->faker->paragraph(),
        ];
        $product = Product::create($data);
        $payload = [
            'title' => $this->faker->words(rand(5, 12), true),
            'details' => $this->faker->paragraph(),
        ];
        $this->actingAs($user, 'sanctum')
            ->json('patch', "api/product/{$product->id}", $payload)
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(
                [
                   'message',
                    'product' => [
                        'id',
                        'title',
                        'details',
                        'created_at',
                        'updated_at',
                    ],
                ]
            );
        $this->assertDatabaseHas('products', $payload);
    }

    public function test_destroy_product_successfully()
    {
        $user = $this->_getUser();
        $data = [
            'title' => $this->faker->words(rand(5, 12), true),
            'details' => $this->faker->paragraph(),
        ];
        $product = Product::create($data);
        $this->actingAs($user, 'sanctum')
            ->json('delete', "api/product/{$product->id}")
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson(
                [
                    'message' => 'Product Deleted Successfully!!!'
                ]
            );
        $this->assertDatabaseMissing('products', $data);
    }
}
