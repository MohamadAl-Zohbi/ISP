<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Renews extends Model
{
    use HasFactory;
    protected $fillable = [
        'from',
        'to',
        'employee_id',
        'service_id',
        'checked_by_owner',
        'total',
        'paid',
        'note',
        'customer_id',
    ];
}
