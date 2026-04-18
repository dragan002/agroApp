<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('AuthController register', function () {

    it('creates a farmer account with valid data', function () {
        $response = $this->postJson('/api/auth/register', [
            'name'                  => 'Novo Farmer',
            'email'                 => 'novo@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(201);
        expect(User::where('email', 'novo@example.com')->exists())->toBeTrue();
    });

    it('creates user with farmer role', function () {
        $this->postJson('/api/auth/register', [
            'name'                  => 'Novo Farmer',
            'email'                 => 'novo@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $user = User::where('email', 'novo@example.com')->first();
        expect($user->role)->toBe('farmer');
    });

    it('sets onboarding_step to 1 on register', function () {
        $this->postJson('/api/auth/register', [
            'name'                  => 'Novo Farmer',
            'email'                 => 'novo@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $user = User::where('email', 'novo@example.com')->first();
        expect($user->onboarding_step)->toBe(1);
    });

    it('returns user api array shape on register', function () {
        $response = $this->postJson('/api/auth/register', [
            'name'                  => 'Novo Farmer',
            'email'                 => 'novo@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertJsonStructure(['id', 'name', 'email', 'role', 'onboardingStep']);
    });

    it('fails when name is missing', function () {
        $response = $this->postJson('/api/auth/register', [
            'email'                 => 'novo@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(422);
    });

    it('fails when email is missing', function () {
        $response = $this->postJson('/api/auth/register', [
            'name'                  => 'Novo Farmer',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(422);
    });

    it('fails when email is already taken', function () {
        User::create([
            'name' => 'Existing', 'email' => 'taken@example.com',
            'password' => 'password', 'role' => 'farmer',
        ]);

        $response = $this->postJson('/api/auth/register', [
            'name'                  => 'New User',
            'email'                 => 'taken@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(422);
    });

    it('fails when password is shorter than 8 characters', function () {
        $response = $this->postJson('/api/auth/register', [
            'name'                  => 'Novo Farmer',
            'email'                 => 'novo@example.com',
            'password'              => 'short',
            'password_confirmation' => 'short',
        ]);

        $response->assertStatus(422);
    });

    it('fails when password confirmation does not match', function () {
        $response = $this->postJson('/api/auth/register', [
            'name'                  => 'Novo Farmer',
            'email'                 => 'novo@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'different123',
        ]);

        $response->assertStatus(422);
    });

});

describe('AuthController login', function () {

    beforeEach(function () {
        $this->farmer = User::create([
            'name'     => 'Login Farmer',
            'email'    => 'login@example.com',
            'password' => 'password123',
            'role'     => 'farmer',
        ]);
    });

    it('logs in with valid credentials', function () {
        $response = $this->postJson('/api/auth/login', [
            'email'    => 'login@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200);
        expect($response->json('id'))->toBe($this->farmer->id);
    });

    it('returns user api array on login', function () {
        $response = $this->postJson('/api/auth/login', [
            'email'    => 'login@example.com',
            'password' => 'password123',
        ]);

        $response->assertJsonStructure(['id', 'name', 'email', 'role']);
    });

    it('returns 401 when password is wrong', function () {
        $response = $this->postJson('/api/auth/login', [
            'email'    => 'login@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401);
    });

    it('returns 401 when email does not exist', function () {
        $response = $this->postJson('/api/auth/login', [
            'email'    => 'nobody@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(401);
    });

    it('fails validation when email is missing', function () {
        $response = $this->postJson('/api/auth/login', [
            'password' => 'password123',
        ]);

        $response->assertStatus(422);
    });

    it('fails validation when password is missing', function () {
        $response = $this->postJson('/api/auth/login', [
            'email' => 'login@example.com',
        ]);

        $response->assertStatus(422);
    });

});

describe('AuthController logout', function () {

    it('logs out an authenticated user', function () {
        $user = User::create([
            'name' => 'Farmer', 'email' => 'farmer@example.com',
            'password' => 'password', 'role' => 'farmer',
        ]);

        $response = $this->actingAs($user)->postJson('/api/auth/logout');

        $response->assertStatus(200);
        expect($response->json('message'))->not->toBeEmpty();
    });

    it('returns 401 for unauthenticated logout attempt', function () {
        $response = $this->postJson('/api/auth/logout');

        $response->assertStatus(401);
    });

});

describe('AuthController me', function () {

    it('returns the authenticated user', function () {
        $user = User::create([
            'name' => 'Me Farmer', 'email' => 'me@example.com',
            'password' => 'password', 'role' => 'farmer',
        ]);

        $response = $this->actingAs($user)->getJson('/api/auth/me');

        $response->assertStatus(200);
        expect($response->json('id'))->toBe($user->id);
        expect($response->json('email'))->toBe('me@example.com');
    });

    it('returns 401 for guest', function () {
        $response = $this->getJson('/api/auth/me');

        $response->assertStatus(401);
    });

});
