<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class TicketFilter
{
    public function apply(Builder $query, Request $request): Builder
    {
        $query = $query
            ->when($request->filled('status'), function ($q) use ($request) {
                $q->whereHas('status', function ($q2) use ($request) {
                    $q2->where('status_code', $request->status);
                });
            })

            ->when($request->filled('email'), function ($q) use ($request) {
                $q->whereHas('customer', function ($q2) use ($request) {
                    $q2->where('email', 'like', "%{$request->email}%");
                });
            })

            ->when($request->filled('phone'), function ($q) use ($request) {
                $q->whereHas('customer', function ($q2) use ($request) {
                    $q2->where('phone', 'like', "%{$request->phone}%");
                });
            })

            ->when($request->filled('from'), function ($q) use ($request) {
                $q->whereDate('created_at', '>=', $request->from);
            })

            ->when($request->filled('to'), function ($q) use ($request) {
                $q->whereDate('created_at', '<=', $request->to);
            });

        return $this->applySorting($query, $request);
    }

    protected function applySorting(Builder $query, Request $request): Builder
    {
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');

        $allowedSorts = [
            'id',
            'created_at',
            'response_date',
            'theme',
        ];

        if (!in_array($sort, $allowedSorts)) {
            $sort = 'created_at';
        }

        if (!in_array(strtolower($direction), ['asc', 'desc'])) {
            $direction = 'desc';
        }

        return $query->orderBy($sort, $direction);
    }
}
