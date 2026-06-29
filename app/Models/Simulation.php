<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Simulation extends Model
{
    protected $fillable = [

        'name',

        'income',

        'house_price',

        'down_payment',

        'tenor',

        'interest',

        'monthly_installment',

        'status'

    ];
}