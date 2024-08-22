<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTypeCrudApiTest extends TestCase
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
        $request = $this->actingAs($this->user)->post('/api/user-types', [
            'name' => $this->faker->name(),
            'hierarchy' => 1,
        ]);
        $request->assertStatus(200);
    }

    public function testIndex()
    {
        $request = $this->actingAs($this->user)->get('/api/user-types');
        $request->assertStatus(200);
    }

    public function testShow()
    {
        $request = $this->actingAs($this->user)->get('/api/user-types/'. $this->userType->id);
        $request->assertStatus(200);
    }
}
