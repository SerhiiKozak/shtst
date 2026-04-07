<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'theme' => $this->theme,
            'text' => $this->text,

            'status' => [
                'id' => $this->status?->id,
                'code' => $this->status?->status_code,
                'name' => $this->status?->status_name,
            ],

            'customer' => $this->customer ? [
                'id' => $this->customer->id,
                'name' => $this->customer->name,
                'email' => $this->customer->email,
                'phone' => $this->customer->phone,
            ] : null,

            'attachments' => $this->getMedia('attachments')->map(function ($file) {
                return [
                    'id' => $file->id,
                    'name' => $file->file_name,
                    'url' => $file->getUrl(),
                    'size' => $file->size,
                    'mime' => $file->mime_type,
                ];
            }),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'response_date' => $this->response_date,
        ];
    }
}
