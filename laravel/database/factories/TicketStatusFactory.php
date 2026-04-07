<?php

namespace Database\Factories;

use App\Models\TicketStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketStatusFactory extends Factory
{
    protected $model = TicketStatus::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {


        return [
            'status_name' => $this->faker->unique()->randomElement([
                'Open',
                'In Progress',
                'Closed',
                'Pending',
                'Resolved',
            ]),
            'status_code' => $this->faker->unique()->randomElement([
                'open',
                'in_progress',
                'closed',
                'pending',
                'resolved',
            ]),
        ];
    }
}
