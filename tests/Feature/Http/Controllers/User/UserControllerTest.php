<?php

namespace Tests\Feature\Http\Controllers\Api\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    /** @test */
    public function getting_all_user_validation_errors()
    {
        $response = $this->json('GET','/api/users', []);

        $response->assertStatus(401);
    }

    /** @test */
    public function getting_all_user()
    {
        $response = $this->json('GET','/api/users', [], $this->headers);

        $response->assertStatus(200);
        $response->assertJsonStructure(['status', 'users', 'currentPage', 'lastPage']);
    }
}
