<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommissionRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_seller_role',
        'second_seller_role',
        'condition_type',
        'commission_first',
        'commission_second',
    ];
}
