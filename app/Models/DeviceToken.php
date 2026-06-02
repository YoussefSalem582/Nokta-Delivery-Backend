<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceToken extends Model
{
    use HasUuids;

    protected $guarded = [];

    /** @use HasFactory<\Database\Factories\DeviceTokenFactory> */
    use HasFactory;
}
