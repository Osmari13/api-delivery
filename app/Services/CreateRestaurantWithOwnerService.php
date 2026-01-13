<?php

namespace App\Services;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class CreateRestaurantWithOwnerService
{
    public function handle(array $data): Restaurant
    {
        return DB::transaction(function () use ($data) {

            // 1️⃣ Crear o recuperar OWNER (usuario global)
            $owner = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name'     => $data['name'],
                    'username' => $data['username'],
                    'phone'    => $data['phone'],
                    'password' => Hash::make($data['password']),
                ]
            );

            // 2️⃣ Crear tenant (restaurant)
            $restaurant = Restaurant::create([
                'id'        => (string) Str::uuid(),
                'name'      => $data['restaurant_name'],
                'subdomain' => $data['subdomain'],
            ]);

            // 3️⃣ Asociar usuario ↔ restaurant (system_db)
            DB::table('restaurant_user')->insert([
                'user_id'       => $owner->id,
                'restaurant_id' => $restaurant->id,
                'created_at'    => now(),
            ]);

            // 4️⃣ Inicializar tenancy (contexto TENANT)
            tenancy()->initialize($restaurant);

            // 5️⃣ Crear roles TENANT
            foreach (['OWNER', 'MANAGER', 'STAFF'] as $role) {
                Role::firstOrCreate([
                    'name' => $role,
                    'guard_name' => 'sanctum',
                ]);
            }

            // 6️⃣ Asignar rol OWNER dentro del tenant
            $owner->assignRole('OWNER');

            // 7️⃣ Finalizar tenancy
            tenancy()->end();

            return $restaurant;
        });
    }
}
