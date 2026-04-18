<?php

use App\Models\FarmerProfile;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

// Helper to create a complete active farmer
function farmerTestMakeActiveFarmer(array $userAttrs = [], array $profileAttrs = []): array
{
    $user = User::create(array_merge([
        'name'     => 'Test Farmer',
        'email'    => 'farmer' . uniqid() . '@test.com',
        'password' => 'password',
        'role'     => 'farmer',
        'phone'    => '+38765100200',
    ], $userAttrs));

    $profile = FarmerProfile::create(array_merge([
        'user_id'   => $user->id,
        'farm_name' => 'Test Farm',
        'location'  => 'Prnjavor',
        'is_active' => true,
    ], $profileAttrs));

    return [$user, $profile];
}

describe('FarmerController index', function () {

    it('returns paginated farmer list', function () {
        farmerTestMakeActiveFarmer(['email' => 'f1@test.com', 'name' => 'Farmer One'], ['farm_name' => 'Farm One']);
        farmerTestMakeActiveFarmer(['email' => 'f2@test.com', 'name' => 'Farmer Two'], ['farm_name' => 'Farm Two']);

        $response = $this->getJson('/api/farmers');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [['id', 'farmName', 'location', 'avatarUrl', 'isActive', 'productCount']],
                'meta' => ['currentPage', 'lastPage', 'total'],
            ]);
        expect($response->json('meta.total'))->toBe(2);
    });

    it('excludes inactive farmers from directory', function () {
        farmerTestMakeActiveFarmer(['email' => 'active@test.com'], ['farm_name' => 'Active Farm', 'is_active' => true]);
        farmerTestMakeActiveFarmer(['email' => 'inactive@test.com'], ['farm_name' => 'Inactive Farm', 'is_active' => false]);

        $response = $this->getJson('/api/farmers');

        $response->assertStatus(200);
        expect($response->json('meta.total'))->toBe(1);
        expect($response->json('data.0.farmName'))->toBe('Active Farm');
    });

    it('returns empty data array when no farmers exist', function () {
        $response = $this->getJson('/api/farmers');

        $response->assertStatus(200);
        expect($response->json('data'))->toHaveCount(0);
        expect($response->json('meta.total'))->toBe(0);
    });

    it('filters farmers by search query', function () {
        farmerTestMakeActiveFarmer(['email' => 'petrovic@test.com'], ['farm_name' => 'Imanje Petrović']);
        farmerTestMakeActiveFarmer(['email' => 'kovac@test.com'], ['farm_name' => 'Mljekara Kovač']);

        $response = $this->getJson('/api/farmers?search=Petrović');

        $response->assertStatus(200);
        expect($response->json('meta.total'))->toBe(1);
        expect($response->json('data.0.farmName'))->toBe('Imanje Petrović');
    });

    it('filters farmers by location', function () {
        farmerTestMakeActiveFarmer(['email' => 'loc1@test.com'], ['farm_name' => 'City Farm', 'location' => 'Prnjavor']);
        farmerTestMakeActiveFarmer(['email' => 'loc2@test.com'], ['farm_name' => 'Remote Farm', 'location' => 'Banja Luka']);

        $response = $this->getJson('/api/farmers?location=Prnjavor');

        $response->assertStatus(200);
        expect($response->json('meta.total'))->toBe(1);
        expect($response->json('data.0.farmName'))->toBe('City Farm');
    });

    it('is accessible to guests', function () {
        $response = $this->getJson('/api/farmers');

        $response->assertStatus(200);
    });

});

describe('FarmerController show', function () {

    it('returns full farmer profile', function () {
        [$user, $profile] = farmerTestMakeActiveFarmer(['email' => 'show@test.com', 'phone' => '+38765111222']);

        $response = $this->getJson("/api/farmers/{$profile->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'id', 'farmName', 'location', 'description', 'avatarUrl',
                'isActive', 'photos', 'user', 'products',
            ]);
        expect($response->json('id'))->toBe($profile->id);
    });

    it('includes contact info in profile user object', function () {
        [$user, $profile] = farmerTestMakeActiveFarmer([
            'email'    => 'contact@test.com',
            'phone'    => '+38765100200',
            'viber'    => '+38765100200',
            'whatsapp' => '+38765100200',
        ]);

        $response = $this->getJson("/api/farmers/{$profile->id}");

        $response->assertStatus(200);
        expect($response->json('user.phone'))->toBe('+38765100200');
        expect($response->json('user.viber'))->toBe('+38765100200');
    });

    it('includes active products in profile', function () {
        [$user, $profile] = farmerTestMakeActiveFarmer(['email' => 'withproducts@test.com']);

        Product::create([
            'user_id'  => $user->id, 'category' => 'povrce',
            'name'     => 'Paradajz', 'price' => 2.50,
            'is_active' => true,
        ]);
        Product::create([
            'user_id'  => $user->id, 'category' => 'voce',
            'name'     => 'Jabuke', 'price' => 1.50,
            'is_active' => false,
        ]);

        $response = $this->getJson("/api/farmers/{$profile->id}");

        $response->assertStatus(200);
        expect($response->json('products'))->toHaveCount(1);
        expect($response->json('products.0.name'))->toBe('Paradajz');
    });

    it('returns 404 when farmer profile does not exist', function () {
        $response = $this->getJson('/api/farmers/99999');

        $response->assertStatus(404);
    });

    it('is accessible to guests', function () {
        [$user, $profile] = farmerTestMakeActiveFarmer(['email' => 'pub@test.com']);

        $response = $this->getJson("/api/farmers/{$profile->id}");

        $response->assertStatus(200);
    });

});

describe('Farmer-only route access control', function () {

    it('returns 401 for guest accessing farmer products', function () {
        $response = $this->getJson('/api/farmer/products');

        $response->assertStatus(401);
    });

    it('returns 403 for customer accessing farmer products', function () {
        $customer = User::create([
            'name' => 'Customer', 'email' => 'customer@test.com',
            'password' => 'password', 'role' => 'customer',
        ]);

        $response = $this->actingAs($customer)->getJson('/api/farmer/products');

        $response->assertStatus(403);
    });

    it('returns 401 for guest accessing onboarding step 2', function () {
        $response = $this->postJson('/api/onboarding/step/2', ['phone' => '+38765111222']);

        $response->assertStatus(401);
    });

    it('returns 403 for customer accessing onboarding step 3', function () {
        $customer = User::create([
            'name' => 'Customer', 'email' => 'cust2@test.com',
            'password' => 'password', 'role' => 'customer',
        ]);

        $response = $this->actingAs($customer)->postJson('/api/onboarding/step/3', [
            'farmName' => 'My Farm',
        ]);

        $response->assertStatus(403);
    });

    it('returns 401 for guest creating a product', function () {
        $response = $this->postJson('/api/farmer/products', [
            'name' => 'Paradajz', 'category' => 'povrce', 'price' => 2.00,
        ]);

        $response->assertStatus(401);
    });

    it('returns 403 for customer creating a product', function () {
        $customer = User::create([
            'name' => 'Cust', 'email' => 'cust3@test.com',
            'password' => 'password', 'role' => 'customer',
        ]);

        $response = $this->actingAs($customer)->postJson('/api/farmer/products', [
            'name' => 'Paradajz', 'category' => 'povrce', 'price' => 2.00,
        ]);

        $response->assertStatus(403);
    });

});
