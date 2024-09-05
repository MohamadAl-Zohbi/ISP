<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Customers extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'number',
        'location',
        'description',
        'expiry',  // Ex: 2024-08-31 19:16:18
        'nationality',
        'user',
        'pass',
        // 'service_id',
        'created_by',
        'is_frozen'
    ];
}
