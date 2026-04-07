<?php

namespace App\Exceptions;

use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    public function report(Throwable $e): void
    {
        parent::report($e);
    }

    public function render($request, Throwable $e)
    {
        return parent::render($request, $e);
    }
    public function register(): void
    {
        $this->renderable(function (ValidationException $e, $request) {

            if ($request->is('api/*') || $request->is('widget/*')) {
                return response()->json([
                    'success' => false,
                    'error' => [
                        'code' => 'VALIDATION_ERROR',
                        'message' => 'Invalid form data',
                        'fields' => collect($e->errors())
                            ->map(fn($msg) => $msg[0])
                    ]
                ], 422);
            }
        });

        $this->renderable(function (ThrottleRequestsException $e, $request) {

            if ($request->is('api/*') || $request->is('widget/*')) {

                $retryAfter = $e->getHeaders()['Retry-After'] ?? null;

                $retryAt = $retryAfter
                    ? now()->addSeconds((int)$retryAfter)
                    : now()->addDay();

                return response()->json([
                    'success' => false,
                    'error' => [
                        'code' => 'RATE_LIMIT_EXCEEDED',
                        'message' => 'You already submitted a ticket. Try later.',
                        'retry_after' => $retryAt->timestamp,
                        'retry_after_human' => $retryAt->toDateTimeString(),
                        'scope' => 'widget-ticket',
                    ]
                ], 429);
            }
        });
    }
}

