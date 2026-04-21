<?php

use App\Models\FarmerProfile;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function searchTestSeedFarmerWithProduct(
    string $farmerEmail,
    string $farmName,
    string $city,
    string $productName,
    string $category = 'povrce',
    bool $freshToday = false
): array {
    $user = User::create([
        'name'     => $farmName . ' Owner',
        'email'    => $farmerEmail,
        'password' => 'password',
        'role'     => 'farmer',
    ]);

    $profile = FarmerProfile::create([
        'user_id'   => $user->id,
        'farm_name' => $farmName,
        'city'      => $city,
        'is_active' => true,
    ]);

    $product = Product::create([
        'user_id'    => $user->id,
        'category'   => $category,
        'name'       => $productName,
        'price'      => 2.00,
        'is_active'  => true,
        'fresh_until' => $freshToday ? now()->addHours(24) : null,
    ]);

    return [$user, $profile, $product];
}

describe('SearchController search', function () {

    it('returns farmers and products keys', function () {
        $response = $this->getJson('/api/search');

        $response->assertStatus(200)
            ->assertJsonStructure(['farmers', 'products']);
    });

    it('returns empty arrays when no data exists', function () {
        $response = $this->getJson('/api/search');

        $response->assertStatus(200);
        expect($response->json('farmers'))->toHaveCount(0);
        expect($response->json('products'))->toHaveCount(0);
    });

    it('finds farmer by farm name query', function () {
        searchTestSeedFarmerWithProduct('f1@test.com', 'Imanje Petrović', 'prnjavor', 'Paradajz');
        searchTestSeedFarmerWithProduct('f2@test.com', 'Mljekara Kovač', 'prnjavor', 'Mlijeko', 'mlijeko');

        $response = $this->getJson('/api/search?q=Petrović');

        $response->assertStatus(200);
        expect($response->json('farmers'))->toHaveCount(1);
        expect($response->json('farmers.0.farmName'))->toBe('Imanje Petrović');
    });

    it('finds product by name query', function () {
        searchTestSeedFarmerWithProduct('s1@test.com', 'Farm A', 'prnjavor', 'Organski paradajz');
        searchTestSeedFarmerWithProduct('s2@test.com', 'Farm B', 'prnjavor', 'Bijeli luk');

        $response = $this->getJson('/api/search?q=paradajz');

        $response->assertStatus(200);
        expect($response->json('products'))->toHaveCount(1);
        expect($response->json('products.0.name'))->toBe('Organski paradajz');
    });

    it('returns both farmers and products matching the query', function () {
        searchTestSeedFarmerWithProduct('multi@test.com', 'Paradajz Farm', 'prnjavor', 'Crveni paradajz');

        $response = $this->getJson('/api/search?q=paradajz');

        $response->assertStatus(200);
        // Product matches by name; farmer does NOT match because query is on farm_name
        expect($response->json('products'))->toHaveCount(1);
    });

    it('filters products by category in search', function () {
        searchTestSeedFarmerWithProduct('cat1@test.com', 'Farm A', 'prnjavor', 'Paradajz', 'povrce');
        searchTestSeedFarmerWithProduct('cat2@test.com', 'Farm B', 'prnjavor', 'Jabuka', 'voce');

        $response = $this->getJson('/api/search?category=povrce');

        $response->assertStatus(200);
        expect($response->json('products'))->toHaveCount(1);
        expect($response->json('products.0.name'))->toBe('Paradajz');
    });

    it('returns all active products when no filters given', function () {
        searchTestSeedFarmerWithProduct('all1@test.com', 'Farm A', 'prnjavor', 'Paradajz', 'povrce');
        searchTestSeedFarmerWithProduct('all2@test.com', 'Farm B', 'prnjavor', 'Jabuka', 'voce');

        $response = $this->getJson('/api/search');

        $response->assertStatus(200);
        expect($response->json('products'))->toHaveCount(2);
    });

    it('filters products by freshOnly', function () {
        searchTestSeedFarmerWithProduct('fr1@test.com', 'Farm A', 'prnjavor', 'Svjezi Paradajz', 'povrce', true);
        searchTestSeedFarmerWithProduct('fr2@test.com', 'Farm B', 'prnjavor', 'Stari Krompir', 'povrce', false);

        $response = $this->getJson('/api/search?freshOnly=true');

        $response->assertStatus(200);
        expect($response->json('products'))->toHaveCount(1);
        expect($response->json('products.0.name'))->toBe('Svjezi Paradajz');
    });

    it('filters farmers by city', function () {
        searchTestSeedFarmerWithProduct('loc1@test.com', 'City Farm', 'prnjavor', 'Paradajz');
        searchTestSeedFarmerWithProduct('loc2@test.com', 'Rural Farm', 'banja_luka', 'Jabuka', 'voce');

        $response = $this->getJson('/api/search?city=prnjavor');

        $response->assertStatus(200);
        expect($response->json('farmers'))->toHaveCount(1);
        expect($response->json('farmers.0.farmName'))->toBe('City Farm');
    });

    it('excludes inactive farmers from search results', function () {
        $user = User::create([
            'name' => 'Inactive Owner', 'email' => 'inact@test.com',
            'password' => 'password', 'role' => 'farmer',
        ]);
        FarmerProfile::create([
            'user_id' => $user->id, 'farm_name' => 'Inactive Farm',
            'city' => 'prnjavor', 'is_active' => false,
        ]);

        $response = $this->getJson('/api/search?q=Inactive');

        $response->assertStatus(200);
        expect($response->json('farmers'))->toHaveCount(0);
    });

    it('excludes inactive products from search results', function () {
        $user = User::create([
            'name' => 'Farmer', 'email' => 'inactprod@test.com',
            'password' => 'password', 'role' => 'farmer',
        ]);
        FarmerProfile::create([
            'user_id' => $user->id, 'farm_name' => 'Test Farm',
            'city' => 'prnjavor', 'is_active' => true,
        ]);
        Product::create([
            'user_id'   => $user->id, 'category' => 'povrce',
            'name'      => 'Hidden Product', 'price' => 1.00,
            'is_active' => false,
        ]);

        $response = $this->getJson('/api/search?q=Hidden');

        $response->assertStatus(200);
        expect($response->json('products'))->toHaveCount(0);
    });

    it('is accessible to guests', function () {
        $response = $this->getJson('/api/search');

        $response->assertStatus(200);
    });

    it('combines q and category filters', function () {
        searchTestSeedFarmerWithProduct('comb1@test.com', 'Farm A', 'prnjavor', 'Organski paradajz', 'povrce');
        searchTestSeedFarmerWithProduct('comb2@test.com', 'Farm B', 'prnjavor', 'Organska jabuka', 'voce');
        searchTestSeedFarmerWithProduct('comb3@test.com', 'Farm C', 'prnjavor', 'Obicna paprika', 'povrce');

        $response = $this->getJson('/api/search?q=Organski&category=povrce');

        $response->assertStatus(200);
        expect($response->json('products'))->toHaveCount(1);
        expect($response->json('products.0.name'))->toBe('Organski paradajz');
    });

});
