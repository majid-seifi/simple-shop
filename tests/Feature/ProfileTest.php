<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    public function test_show_profile_return_valid_data()
    {
        $user = $this->_getUser('User');
        $this->actingAs($user, 'sanctum')
            ->json('get', "api/profile")
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(
                [
                    'user',
                    'products'
                ]
            );
    }
}
