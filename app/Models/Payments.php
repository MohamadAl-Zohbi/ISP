<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;
    protected $fillable = [
        'amount',
        'phone_number',
        'description',
        'who',
        'payment_method',
        'employee_id',
        'renew_id'
    ];
}
