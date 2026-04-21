<?php

use App\Models\FarmerProfile;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('StateController', function () {

    it('returns auth null when guest', function () {
        $response = $this->getJson('/api/state');

        $response->assertStatus(200);
        expect($response->json('auth'))->toBeNull();
    });

    it('returns categories keyed by slug', function () {
        $response = $this->getJson('/api/state');

        $response->assertStatus(200);
        $categories = $response->json('categories');
        expect($categories)->toBeArray();
        expect($categories)->toHaveKey('povrce');
        expect($categories)->toHaveKey('voce');
        expect($categories['povrce'])->toBe('Povrće');
    });

    it('returns farmers array even when no farmers exist', function () {
        $response = $this->getJson('/api/state');

        $response->assertStatus(200);
        expect($response->json('farmers'))->toBeArray();
        expect($response->json('farmers'))->toHaveCount(0);
    });

    it('returns only active farmers', function () {
        $activeFarmer = User::create([
            'name' => 'Active Farmer', 'email' => 'active@test.com',
            'password' => 'password', 'role' => 'farmer',
        ]);
        FarmerProfile::create([
            'user_id' => $activeFarmer->id, 'farm_name' => 'Active Farm',
            'city' => 'prnjavor', 'is_active' => true,
        ]);

        $inactiveFarmer = User::create([
            'name' => 'Inactive Farmer', 'email' => 'inactive@test.com',
            'password' => 'password', 'role' => 'farmer',
        ]);
        FarmerProfile::create([
            'user_id' => $inactiveFarmer->id, 'farm_name' => 'Inactive Farm',
            'city' => 'prnjavor', 'is_active' => false,
        ]);

        $response = $this->getJson('/api/state');

        $response->assertStatus(200);
        expect($response->json('farmers'))->toHaveCount(1);
        expect($response->json('farmers.0.farmName'))->toBe('Active Farm');
    });

    it('returns farmer card shape', function () {
        $farmer = User::create([
            'name' => 'Test Farmer', 'email' => 'tf@test.com',
            'password' => 'password', 'role' => 'farmer',
        ]);
        FarmerProfile::create([
            'user_id' => $farmer->id, 'farm_name' => 'Test Farm',
            'city' => 'prnjavor', 'is_active' => true,
        ]);

        $response = $this->getJson('/api/state');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'farmers' => [
                    '*' => ['id', 'farmName', 'location', 'avatarUrl', 'isActive', 'productCount'],
                ],
            ]);
    });

    it('returns auth user when logged in', function () {
        $user = User::create([
            'name' => 'Logged In Farmer', 'email' => 'li@test.com',
            'password' => 'password', 'role' => 'farmer',
        ]);

        $response = $this->actingAs($user)->getJson('/api/state');

        $response->assertStatus(200);
        expect($response->json('auth.id'))->toBe($user->id);
        expect($response->json('auth.role'))->toBe('farmer');
    });

    it('response has auth, farmers, and categories keys', function () {
        $response = $this->getJson('/api/state');

        $response->assertStatus(200)
            ->assertJsonStructure(['auth', 'farmers', 'categories']);
    });

});
