<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Ticket;
use App\Models\TicketStatus;

class WidgetController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'phone' => ['required', 'regex:/^\+[1-9]\d{1,14}$/'],
            'email' => 'required|email',
            'theme' => 'required|string',
            'text' => 'required|string',
        ]);

        $ticket = null;
        $customer = null;

        DB::transaction(function () use ($request, &$ticket, &$customer) {

            $customer = Customer::firstOrCreate(
                ['phone' => $request->phone],
                [
                    'name' => $request->name,
                    'email' => $request->email
                ]
            );

            $status = TicketStatus::byCode('new');

            if (!$status) {
                throw new \Exception('Default status not found');
            }

            $ticket = Ticket::create([
                'theme' => strip_tags($request->theme),
                'text' => strip_tags($request->text),
                'ticket_status_id' => $status->id,
            ]);

            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $ticket->addMedia($file)
                        ->toMediaCollection('attachments');
                }
            }

            $ticket->customers()->syncWithoutDetaching([$customer->id]);
        });

        return response()->json([
            'success' => true,
            'ticket' => [
                'id' => $ticket->id
            ]
        ]);
    }
}
