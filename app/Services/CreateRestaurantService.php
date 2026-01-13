<?php
namespace App\Services;

use App\Models\Restaurant;
use Illuminate\Support\Str;

class CreateRestaurantService
{
    public function create(array $data): Restaurant
    {
        return Restaurant::create([
            'id'        => Str::uuid(),
            'name'      => $data['name'],
            'subdomain' => $data['subdomain'],
            'status'   => 'ACTIVE',
            'location'  => $data['location'] ?? null,
            'db_name'   => 'tenant_' . Str::slug($data['subdomain']),
        ]);
    }
}
