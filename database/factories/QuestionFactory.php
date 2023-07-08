<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'round' => fake()->numberBetween(0, 3),

            'value' => fake()->randomElement([
                        200,
                        400,
                        600,
                        800,
                        1000,
                        400,
                        800,
                        1200,
                        1600,
                        2000
                    ]),

            'daily_double_value' => fake()->randomNumber(4, false),

            'category' => fake()->words(
                            fake()->numberBetween(0, 3), true
                        ),

            'comments' => fake()->sentence(),

            'answer' => fake()->sentence(
                            fake()->numberBetween(4, 15)
                        ),

            'question' => fake()->sentence(
                            fake()->numberBetween(0, 5)
                        ),

            'air_date' => fake()->dateTimeBetween( '-34 years', now() ),

            'notes' => fake()->boolean() ? fake()->paragraph() : null,
        ];
    }
}
