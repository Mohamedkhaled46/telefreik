<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\CustomerDetails;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class CustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'),
            'mobile' => $this->faker->numerify("##########"),
            'phone' => $this->faker->PhoneNumber,
            'image' => $this->faker->imageUrl($width = 640, $height = 480),
            'status' => "Active",
            'SUUID' => null,
            'loggedBy' => 'defualt',
            'country_id' => 63,
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterMaking(function (Customer $customer) {
            //
        })->afterCreating(function (Customer $customer) {
            CustomerDetails::factory()->for($customer)->create();
        });
    }
}
