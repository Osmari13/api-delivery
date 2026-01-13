<?php

namespace App\Models;


class Restaurant extends Tenant
{
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
