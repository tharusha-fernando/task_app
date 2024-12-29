<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence,
            'priority' => null,//$this->faker->randomElement(['low', 'medium', 'high']),
            'project_id' => \App\Models\Project::factory(),
            'created_by' => \App\Models\User::factory(),

            //
        ];
    }
}
