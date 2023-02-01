<?php

namespace Database\Factories;

use App\Models\CreditCard;
use Illuminate\Database\Eloquent\Factories\Factory;

class CreditCardFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CreditCard::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'creditCardNumber'=>$this->faker->creditCardNumber,
            'creditCardExpirationDate'=>$this->faker->creditCardExpirationDate ,
            'creditCardType'=>$this->faker->creditCardType,
            'state'=>'pending',
            'customer_id' =>$this->faker->numberBetween(1,5)
        ];
    }
}
