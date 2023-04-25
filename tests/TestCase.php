<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations;

    private Generator $faker;
    public function setUp()
    : void {

        parent::setUp();
        $this->faker = Factory::create();
        Artisan::call('migrate:refresh');
    }

    public function __get($key) {

        if ($key === 'faker')
            return $this->faker;
        throw new \Exception('Unknown Key Requested');
    }

    protected function _getUser($role = 'Administrator')
    {
        Artisan::call('db:seed');

        $email = $this->faker->email;
        $password = $this->faker->password;
        $data = [
            'name' => $this->faker->name,
            'email' => $email,
            'password' => Hash::make($password),
        ];
        $user = User::create($data);
        $user->assignRole($role);
        return $user;
    }
}
