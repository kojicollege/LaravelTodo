<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

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
            'folder_id' => 1,
            'title' => $this->faker->word,
            'status' => $this->faker->randomElement([1, 2, 3]),
            'due_date' => Carbon::now()->addDay(rand(1, 3)),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

    public function withTitle(string $title)
    {
        return $this->state([
            'title' => $title,
        ]);
    }
}