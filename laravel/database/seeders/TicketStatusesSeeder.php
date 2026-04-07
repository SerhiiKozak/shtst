<?php

namespace Database\Seeders;

use App\Models\TicketStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketStatusesSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $statusList = [
            'new',
            'in_progress',
            'completed'
        ];

        foreach ($statusList as $status) {
            $statusName = ucwords(str_replace('_', ' ', $status));
            TicketStatus::create(['status_name' => $statusName , 'status_code' => $status]);
        }
    }
}
