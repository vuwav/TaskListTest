<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $name = $this->faker->unique()->firstName,
            'family' => $this->faker->lastName,
            'surname' => $this->faker->firstName,
            'login' => $name,
            'password' => $pass = Hash::make('secret23'),
            'role' => 1,
            'manager_id' => 1,
            'api_token' => $pass
        ];
    }
}
