<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketStatus;
use Illuminate\Http\Request;
use App\Http\Resources\TicketResource;
use App\Filters\TicketFilter;

class TicketController extends Controller
{
    /**
     * 📋 Список тікетів + фільтри
     */
    public function index(Request $request)
    {
        $query = (new TicketFilter)->apply(Ticket::query(), $request);

        $tickets = $query
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => TicketResource::collection($tickets),
        ]);
    }

    /**
     * 🔍 Один тікет
     */
    public function show(Ticket $ticket)
    {
        return response()->json([
            'success' => true,
            'data' => new TicketResource($ticket),
        ]);
    }

    /**
     * 🔄 Зміна статусу
     */
    public function updateStatus(Request $request, Ticket $ticket)
    {
        $request->validate([
            'status' => ['required', 'string']
        ]);

        $status = TicketStatus::byCode($request->status);

        if (!$status) {
            return response()->json([
                'success' => false,
                'error' => [
                    'code' => 'INVALID_STATUS',
                    'message' => 'Status not found'
                ]
            ], 422);
        }

        $ticket->update([
            'ticket_status_id' => $status->id,
            'response_date' => now(),
        ]);

        return response()->json([
            'success' => true,
            'data' => new TicketResource($ticket),
        ]);
    }
}
