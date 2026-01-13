<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Restaurant extends Tenant
{
    use HasUuids; 
    protected $keyType = 'string';  // ← UUID es string
    public $incrementing = false;

    protected $table = 'restaurants';

    protected $fillable = [
        'id',
        'name',
        'subdomain',
        'db_name',
        'status',
        'location',
    ];
}
