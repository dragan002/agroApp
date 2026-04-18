<?php

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function productTestMakeFarmer(?string $email = null): User
{
    return User::create([
        'name'     => 'Farmer',
        'email'    => $email ?? 'farmer' . uniqid() . '@test.com',
        'password' => 'password',
        'role'     => 'farmer',
        'phone'    => '+38765100200',
    ]);
}

function productTestMakeActiveProduct(User $farmer, array $attrs = []): Product
{
    return Product::create(array_merge([
        'user_id'    => $farmer->id,
        'category'   => 'povrce',
        'name'       => 'Test Product',
        'price'      => 2.00,
        'is_active'  => true,
        'fresh_today' => false,
    ], $attrs));
}

describe('ProductController index', function () {

    it('returns paginated product list', function () {
        $farmer = productTestMakeFarmer();
        productTestMakeActiveProduct($farmer, ['name' => 'Paradajz']);
        productTestMakeActiveProduct($farmer, ['name' => 'Paprika']);

        $response = $this->getJson('/api/products');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [['id', 'name', 'category', 'price', 'freshToday']],
                'meta' => ['currentPage', 'lastPage', 'total'],
            ]);
        expect($response->json('meta.total'))->toBe(2);
    });

    it('excludes inactive products', function () {
        $farmer = productTestMakeFarmer();
        productTestMakeActiveProduct($farmer, ['name' => 'Active Product', 'is_active' => true]);
        productTestMakeActiveProduct($farmer, ['name' => 'Inactive Product', 'is_active' => false]);

        $response = $this->getJson('/api/products');

        $response->assertStatus(200);
        expect($response->json('meta.total'))->toBe(1);
        expect($response->json('data.0.name'))->toBe('Active Product');
    });

    it('returns empty list when no products exist', function () {
        $response = $this->getJson('/api/products');

        $response->assertStatus(200);
        expect($response->json('data'))->toHaveCount(0);
    });

    it('filters products by category', function () {
        $farmer = productTestMakeFarmer();
        productTestMakeActiveProduct($farmer, ['name' => 'Paradajz', 'category' => 'povrce']);
        productTestMakeActiveProduct($farmer, ['name' => 'Jabuka', 'category' => 'voce']);

        $response = $this->getJson('/api/products?category=povrce');

        $response->assertStatus(200);
        expect($response->json('meta.total'))->toBe(1);
        expect($response->json('data.0.name'))->toBe('Paradajz');
    });

    it('filters products by freshOnly flag', function () {
        $farmer = productTestMakeFarmer();
        productTestMakeActiveProduct($farmer, ['name' => 'Fresh Paradajz', 'fresh_today' => true]);
        productTestMakeActiveProduct($farmer, ['name' => 'Not Fresh Krompir', 'fresh_today' => false]);

        $response = $this->getJson('/api/products?freshOnly=true');

        $response->assertStatus(200);
        expect($response->json('meta.total'))->toBe(1);
        expect($response->json('data.0.name'))->toBe('Fresh Paradajz');
    });

    it('filters products by search term', function () {
        $farmer = productTestMakeFarmer();
        productTestMakeActiveProduct($farmer, ['name' => 'Organski paradajz']);
        productTestMakeActiveProduct($farmer, ['name' => 'Bijeli luk']);

        $response = $this->getJson('/api/products?search=paradajz');

        $response->assertStatus(200);
        expect($response->json('meta.total'))->toBe(1);
        expect($response->json('data.0.name'))->toBe('Organski paradajz');
    });

    it('is accessible to guests', function () {
        $response = $this->getJson('/api/products');

        $response->assertStatus(200);
    });

});

describe('ProductController show', function () {

    it('returns product detail', function () {
        $farmer = productTestMakeFarmer();
        $product = productTestMakeActiveProduct($farmer, ['name' => 'Paradajz', 'description' => 'Svjezi paradajz']);

        $response = $this->getJson("/api/products/{$product->id}");

        $response->assertStatus(200)
            ->assertJsonStructure(['id', 'name', 'category', 'price', 'description', 'freshToday', 'photos']);
        expect($response->json('id'))->toBe($product->id);
        expect($response->json('name'))->toBe('Paradajz');
    });

    it('returns 404 for nonexistent product', function () {
        $response = $this->getJson('/api/products/99999');

        $response->assertStatus(404);
    });

    it('is accessible to guests', function () {
        $farmer = productTestMakeFarmer();
        $product = productTestMakeActiveProduct($farmer);

        $response = $this->getJson("/api/products/{$product->id}");

        $response->assertStatus(200);
    });

});

describe('ProductController myProducts', function () {

    it('returns only the authenticated farmers own products', function () {
        $farmer1 = productTestMakeFarmer('f1@test.com');
        $farmer2 = productTestMakeFarmer('f2@test.com');
        productTestMakeActiveProduct($farmer1, ['name' => 'Farmer1 Product']);
        productTestMakeActiveProduct($farmer2, ['name' => 'Farmer2 Product']);

        $response = $this->actingAs($farmer1)->getJson('/api/farmer/products');

        $response->assertStatus(200);
        expect($response->json())->toHaveCount(1);
        expect($response->json('0.name'))->toBe('Farmer1 Product');
    });

    it('includes inactive products in own list', function () {
        $farmer = productTestMakeFarmer();
        productTestMakeActiveProduct($farmer, ['name' => 'Active', 'is_active' => true]);
        productTestMakeActiveProduct($farmer, ['name' => 'Inactive', 'is_active' => false]);

        $response = $this->actingAs($farmer)->getJson('/api/farmer/products');

        $response->assertStatus(200);
        expect($response->json())->toHaveCount(2);
    });

    it('returns empty array when farmer has no products', function () {
        $farmer = productTestMakeFarmer();

        $response = $this->actingAs($farmer)->getJson('/api/farmer/products');

        $response->assertStatus(200);
        expect($response->json())->toHaveCount(0);
    });

});

describe('ProductController store', function () {

    it('creates a product successfully', function () {
        $farmer = productTestMakeFarmer();

        $response = $this->actingAs($farmer)->postJson('/api/farmer/products', [
            'name'     => 'Novi Paradajz',
            'category' => 'povrce',
            'price'    => 2.50,
        ]);

        $response->assertStatus(201);
        expect(Product::where('name', 'Novi Paradajz')->exists())->toBeTrue();
    });

    it('assigns product to authenticated farmer', function () {
        $farmer = productTestMakeFarmer();

        $this->actingAs($farmer)->postJson('/api/farmer/products', [
            'name'     => 'Moj Paradajz',
            'category' => 'povrce',
            'price'    => 2.50,
        ]);

        $product = Product::where('name', 'Moj Paradajz')->first();
        expect($product->user_id)->toBe($farmer->id);
    });

    it('returns created product shape', function () {
        $farmer = productTestMakeFarmer();

        $response = $this->actingAs($farmer)->postJson('/api/farmer/products', [
            'name'        => 'Paprika',
            'category'    => 'povrce',
            'price'       => 1.80,
            'description' => 'Crvena babura',
            'priceUnit'   => 'kg',
            'freshToday'  => true,
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['id', 'name', 'category', 'price', 'priceUnit', 'freshToday', 'photos']);
        expect($response->json('freshToday'))->toBeTrue();
        expect($response->json('priceUnit'))->toBe('kg');
    });

    it('fails when name is missing', function () {
        $farmer = productTestMakeFarmer();

        $response = $this->actingAs($farmer)->postJson('/api/farmer/products', [
            'category' => 'povrce',
            'price'    => 2.50,
        ]);

        $response->assertStatus(422);
    });

    it('fails when category is missing', function () {
        $farmer = productTestMakeFarmer();

        $response = $this->actingAs($farmer)->postJson('/api/farmer/products', [
            'name'  => 'Paradajz',
            'price' => 2.50,
        ]);

        $response->assertStatus(422);
    });

    it('fails when category is not a valid enum value', function () {
        $farmer = productTestMakeFarmer();

        $response = $this->actingAs($farmer)->postJson('/api/farmer/products', [
            'name'     => 'Paradajz',
            'category' => 'invalid_category',
            'price'    => 2.50,
        ]);

        $response->assertStatus(422);
    });

    it('fails when price is missing', function () {
        $farmer = productTestMakeFarmer();

        $response = $this->actingAs($farmer)->postJson('/api/farmer/products', [
            'name'     => 'Paradajz',
            'category' => 'povrce',
        ]);

        $response->assertStatus(422);
    });

    it('fails when price is negative', function () {
        $farmer = productTestMakeFarmer();

        $response = $this->actingAs($farmer)->postJson('/api/farmer/products', [
            'name'     => 'Paradajz',
            'category' => 'povrce',
            'price'    => -1,
        ]);

        $response->assertStatus(422);
    });

});

describe('ProductController update', function () {

    it('updates own product successfully', function () {
        $farmer = productTestMakeFarmer();
        $product = productTestMakeActiveProduct($farmer, ['name' => 'Staro Ime']);

        $response = $this->actingAs($farmer)->patchJson("/api/farmer/products/{$product->id}", [
            'name' => 'Novo Ime',
        ]);

        $response->assertStatus(200);
        expect($product->fresh()->name)->toBe('Novo Ime');
    });

    it('returns 403 when farmer tries to update another farmers product', function () {
        $farmer1 = productTestMakeFarmer('own@test.com');
        $farmer2 = productTestMakeFarmer('other@test.com');
        $product = productTestMakeActiveProduct($farmer1, ['name' => 'Farmer1 Product']);

        $response = $this->actingAs($farmer2)->patchJson("/api/farmer/products/{$product->id}", [
            'name' => 'Hacked Name',
        ]);

        $response->assertStatus(403);
        expect($product->fresh()->name)->toBe('Farmer1 Product');
    });

    it('returns 404 for nonexistent product', function () {
        $farmer = productTestMakeFarmer();

        $response = $this->actingAs($farmer)->patchJson('/api/farmer/products/99999', [
            'name' => 'Whatever',
        ]);

        $response->assertStatus(404);
    });

    it('returns updated product shape', function () {
        $farmer = productTestMakeFarmer();
        $product = productTestMakeActiveProduct($farmer);

        $response = $this->actingAs($farmer)->patchJson("/api/farmer/products/{$product->id}", [
            'price' => 9.99,
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['id', 'name', 'category', 'price', 'freshToday', 'photos']);
        expect($response->json('price'))->toBe(9.99);
    });

    it('fails when category update uses invalid value', function () {
        $farmer = productTestMakeFarmer();
        $product = productTestMakeActiveProduct($farmer);

        $response = $this->actingAs($farmer)->patchJson("/api/farmer/products/{$product->id}", [
            'category' => 'invalid',
        ]);

        $response->assertStatus(422);
    });

});

describe('ProductController toggleFresh', function () {

    it('toggles fresh_today from false to true', function () {
        $farmer = productTestMakeFarmer();
        $product = productTestMakeActiveProduct($farmer, ['fresh_today' => false]);

        $response = $this->actingAs($farmer)->patchJson("/api/farmer/products/{$product->id}/fresh");

        $response->assertStatus(200);
        expect($product->fresh()->fresh_today)->toBeTrue();
    });

    it('toggles fresh_today from true to false', function () {
        $farmer = productTestMakeFarmer();
        $product = productTestMakeActiveProduct($farmer, ['fresh_today' => true]);

        $response = $this->actingAs($farmer)->patchJson("/api/farmer/products/{$product->id}/fresh");

        $response->assertStatus(200);
        expect($product->fresh()->fresh_today)->toBeFalse();
    });

    it('returns id and freshToday in response', function () {
        $farmer = productTestMakeFarmer();
        $product = productTestMakeActiveProduct($farmer, ['fresh_today' => false]);

        $response = $this->actingAs($farmer)->patchJson("/api/farmer/products/{$product->id}/fresh");

        $response->assertStatus(200)
            ->assertJsonStructure(['id', 'freshToday']);
        expect($response->json('id'))->toBe($product->id);
        expect($response->json('freshToday'))->toBeTrue();
    });

    it('returns 403 when toggling another farmers product', function () {
        $farmer1 = productTestMakeFarmer('tog1@test.com');
        $farmer2 = productTestMakeFarmer('tog2@test.com');
        $product = productTestMakeActiveProduct($farmer1, ['fresh_today' => false]);

        $response = $this->actingAs($farmer2)->patchJson("/api/farmer/products/{$product->id}/fresh");

        $response->assertStatus(403);
        expect($product->fresh()->fresh_today)->toBeFalse();
    });

});

describe('ProductController destroy', function () {

    it('soft-deletes product by setting is_active to false', function () {
        $farmer = productTestMakeFarmer();
        $product = productTestMakeActiveProduct($farmer);

        $response = $this->actingAs($farmer)->deleteJson("/api/farmer/products/{$product->id}");

        $response->assertStatus(200);
        expect($product->fresh()->is_active)->toBeFalse();
    });

    it('product still exists in database after deletion', function () {
        $farmer = productTestMakeFarmer();
        $product = productTestMakeActiveProduct($farmer);

        $this->actingAs($farmer)->deleteJson("/api/farmer/products/{$product->id}");

        expect(Product::find($product->id))->not->toBeNull();
    });

    it('returns 403 when deleting another farmers product', function () {
        $farmer1 = productTestMakeFarmer('del1@test.com');
        $farmer2 = productTestMakeFarmer('del2@test.com');
        $product = productTestMakeActiveProduct($farmer1);

        $response = $this->actingAs($farmer2)->deleteJson("/api/farmer/products/{$product->id}");

        $response->assertStatus(403);
        expect($product->fresh()->is_active)->toBeTrue();
    });

    it('returns 404 for nonexistent product', function () {
        $farmer = productTestMakeFarmer();

        $response = $this->actingAs($farmer)->deleteJson('/api/farmer/products/99999');

        $response->assertStatus(404);
    });

    it('deleted product no longer appears in public product list', function () {
        $farmer = productTestMakeFarmer();
        $product = productTestMakeActiveProduct($farmer, ['name' => 'To Be Deleted']);

        $this->actingAs($farmer)->deleteJson("/api/farmer/products/{$product->id}");

        $response = $this->getJson('/api/products');
        expect($response->json('meta.total'))->toBe(0);
    });

});
