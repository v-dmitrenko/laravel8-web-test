<?php

namespace Tests\Feature\Http\Controllers\Api\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    /** @test */
    public function login_displays_validation_errors()
    {
        $response = $this->json('POST','/api/auth/login', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email', 'password']);
    }

    /** @test */
    public function login_user()
    {
        $this->createEnvironment();
        $response = $this->json('POST','/api/auth/login', [
            'email'         => $this->userMail,
            'password'      => $this->userPassword,
        ]);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
        $response->assertJsonStructure(['status', 'token']);
    }

    /** @test */
    public function refresh_token_displays_validation_errors()
    {
        $response = $this->json('POST','/api/auth/refresh-token', []);

        $response->assertStatus(405);
    }

    /** @test */
    public function refresh_token_for_user()
    {
        $response = $this->json('POST','/api/auth/refresh-token', [], $this->headers);

        $response->assertStatus(200);
        $response->assertJsonStructure(['status', 'token']);
    }

    /** @test */
    public function logout_displays_validation_errors()
    {
        $response = $this->json('POST','/api/auth/logout');

        $response->assertStatus(401);
    }

    /** @test */
    public function logout_user()
    {
        $this->createEnvironment();
        $response = $this->json('POST','/api/auth/logout', [], $this->headers);

        $response->assertStatus(200);
        $response->assertJsonStructure(['status', 'message']);
    }
}
