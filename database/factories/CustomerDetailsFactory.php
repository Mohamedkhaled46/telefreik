<?php

namespace Database\Factories;

use App\Models\CustomerDetails;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CustomerDetailsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CustomerDetails::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'firebase_token' => Str::random(64),
            'os_system' => $this->faker->randomElement(['android', 'ios']),
            'os_version' => 10,
            'customer_id' => 1,
        ];
    }
}
