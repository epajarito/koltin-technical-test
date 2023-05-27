<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;

class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'message' => $this->faker->sentence,
            'user_id_sender' => User::query()
                ->inRandomOrder()
                ->value('id'),
            'created_at' => $this->faker->dateTimeBetween('-5 hours')
        ];
    }
}
