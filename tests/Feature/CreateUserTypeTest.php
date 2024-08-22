<?php

namespace Tests\Feature;

use App\Models\UserType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateUserTypeTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected UserType $userType;
    public function setUp(): void
    {
        parent::setUp();
        $this->userType = UserType::factory()->create();
    }

    public function testUserTypeCreation()
    {
        $this->assertDatabaseHas('user_types', ['id' => $this->userType->id]);
    }
}
