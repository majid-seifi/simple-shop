<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * test user login
     *
     * @return void
     */
    public function test_login_returns_data_in_valid_format()
    {
        $email = $this->faker->email;
        $password = $this->faker->password;
        $data = [
            'name' => $this->faker->name,
            'email' => $email,
            'password' => Hash::make($password),
        ];

        User::create($data);
        $payload = [
            'email' => $email,
            'password' => $password,
        ];
        $this->json('post', 'api/auth/login', $payload)
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(
                [
                    'status',
                    'message',
                    'accesses',
                    'token'
                ]
            );
    }
    /**
     * test user email validation
     *
     * @return void
     */
    public function test_login_email_validation_error()
    {
        $password = $this->faker->password;
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => Hash::make($password),
        ];

        User::create($data);
        $payload = [
            'email' => $this->faker->name,
            'password' => $password,
        ];
        $this->json('post', 'api/auth/login', $payload)
            ->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertSimilarJson(
                [
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => [
                        'email' => ['The email must be a valid email address.']
                    ]
                ]
            );
    }

    /**
     * test user email validation
     *
     * @return void
     */
    public function test_login_password_validation_error()
    {
        $email = $this->faker->email;
        $password = $this->faker->password;
        $data = [
            'name' => $this->faker->name,
            'email' => $email,
            'password' => Hash::make($password),
        ];

        User::create($data);
        $payload = [
            'email' => $email,
        ];
        $this->json('post', 'api/auth/login', $payload)
            ->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertSimilarJson(
                [
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => [
                        'password' => ['The password field is required.']
                    ]
                ]
            );
    }

    /**
     * test invalid email and password
     *
     * @return void
     */
    public function test_login_invalid_email_and_password_error()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => $this->faker->password,
        ];
        User::create($data);

        $payload = [
            'email' => $this->faker->email,
            'password' => $this->faker->password,
        ];
        $this->json('post', 'api/auth/login', $payload)
            ->assertStatus(Response::HTTP_FORBIDDEN)
            ->assertExactJson(
                [
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ]
            );
    }
}
