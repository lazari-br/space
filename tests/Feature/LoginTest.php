<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    const EMAIL = 'test@test.com';
    const PWD = 'Senha@123';

    protected User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::create([
            'name' => 'test aa',
            'email' => self::EMAIL,
            'password' => self::PWD,
            'user_type_id' => UserType::factory()->create()->id
        ]);
    }

    public function testLogin()
    {
        $response = $this->post('/api/login', [
            'email' => self::EMAIL,
            'password' => self::PWD
        ]);
        $response->assertStatus(200);
    }

    public function testLoginError()
    {
        $response = $this->post('/api/login', [
            'email' => self::EMAIL,
            'password' => self::PWD.'error_12'
        ]);
        $response->assertStatus(200);
    }
}
