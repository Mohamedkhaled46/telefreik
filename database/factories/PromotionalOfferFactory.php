<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PromotionalOfferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => [
                'ar' => 'عرض',
                'en' => 'offer',
            ],
            'brief' => [
                'ar' => 'شرح مختصر',
                'en' => 'Brief Description',
            ],
            'active' => 1,
            'user_id' => 1,
            'image' => 'PromotionalOffers/filler.png',
        ];
    }
}
