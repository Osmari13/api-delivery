<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\CreateRestaurantWithOwnerService;
use Illuminate\Http\Request;

class RestaurantOnboardingController extends Controller
{
    //
    public function store(
        Request $request,
        CreateRestaurantWithOwnerService $service
    ) {
        $data = $request->validate([
            // Usuario
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:150|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:255',
            'password' => 'required|string|min:8',

            // Restaurante
            'restaurant_name' => 'required|string|max:255',
            'subdomain' => 'required|string|max:50|unique:restaurants,subdomain',
        ]);

        $result = $service->handle($data);

        return response()->json($result, 201);
    }

}
