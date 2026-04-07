<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Ticket;
use App\Models\TicketStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Ticket>
 */
class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'theme' => $this->faker->sentence(3),
            'text' => $this->faker->paragraph(),
            'ticket_status_id' => TicketStatus::inRandomOrder()->first()?->id,
            'response_date' => $this->faker->optional()->dateTime(),
            'customer_id' => Customer::inRandomOrder()->first()?->id,
        ];
    }
}
