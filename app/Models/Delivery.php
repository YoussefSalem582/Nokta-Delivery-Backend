<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasUuids;

    protected $guarded = [];

    /** @use HasFactory<\Database\Factories\DeliveryFactory> */
    use HasFactory;
}
