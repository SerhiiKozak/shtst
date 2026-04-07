<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Database\Factories\CustomerFactory;

class Customer extends Model
{
    /** @use HasFactory<CustomerFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
    ];

    public static function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],

            'phone' => [
                'required',
                'string',
                'regex:/^\+[1-9]\d{1,14}$/'
            ],

            'email' => ['nullable', 'email', 'max:255'],
        ];
    }
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }
}
