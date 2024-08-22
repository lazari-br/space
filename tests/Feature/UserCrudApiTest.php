<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserCrudApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected User $user;
    protected UserType $userType;
    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->userType = UserType::factory()->create();
    }

    public function testStore()
    {
        $request = $this->actingAs($this->user)->post('/api/users', [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'password' => 'Senha@123',
            'repeated_password' => 'Senha@123',
            'user_type_id' => $this->userType->id
        ]);
        $request->assertStatus(200);
    }

    public function testIndex()
    {
        $request = $this->actingAs($this->user)->get('/api/users');
        $request->assertStatus(200);
    }

    public function testShow()
    {
        $request = $this->actingAs($this->user)->get('/api/users/'. $this->user->id);
        $request->assertStatus(200);
    }

    public function testUpdate()
    {
        $newName = $this->faker->name();
        $request = $this->actingAs($this->user)->put('/api/users/'.$this->user->id, [
            'name' => $newName
        ]);
        $request->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'name' => $newName,
            'id' => $this->user->id,
        ]);
    }
}
