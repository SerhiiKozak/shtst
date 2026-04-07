<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Database\Factories\TicketFactory;

class Ticket extends Model implements HasMedia
{
    /** @use HasFactory<TicketFactory> */
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'theme',
        'text',
        'ticket_status_id',
        'customer_id',
        'response_date',
    ];

    protected $casts = ['response_date' => 'datetime',];

    protected $with = ['status', 'customer'];

    public function status(): BelongsTo
    {
        return $this->belongsTo(TicketStatus::class, 'ticket_status_id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('attachments');
    }
}
