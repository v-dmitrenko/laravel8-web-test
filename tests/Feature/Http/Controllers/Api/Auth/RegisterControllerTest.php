<?php

namespace Tests\Feature\Http\Controllers\Api\Auth;

use App\Models\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    /**
     * @test
     * @return void
     */
    public function register_displays_the_register_form()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    /** @test */
    public function register_displays_validation_errors()
    {
        $response = $this->json('POST','/api/auth/register', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name', 'email', 'password']);
    }

    /** @test */
    public function register_user_creates()
    {
        $faker = Factory::create();
        $name = $faker->name;
        $email = $faker->unique()->safeEmail;
        $response = $this->json('POST','/api/auth/register', [
            'name'                  => $name,
            'email'                 => $email,
            'password'              => '123456',
            'password_confirmation' => '123456',
        ]);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
        $this->assertDatabaseHas('users', [
            'name' => $name,
            'email' => $email
        ]);
    }

    /** @test */
    public function register_email_confirmation_creates()
    {
        $faker = Factory::create();
        $name = $faker->name;
        $email = $faker->unique()->safeEmail;

        // create mock to catch registration email
        $mock = \Mockery::mock($this->app['mailer']->getSwiftMailer());
        $this->app['mailer']->setSwiftMailer($mock);
        $mock->shouldReceive('send')->once()->andReturnUsing(function ($msg) use($email) {
            $this->assertEquals('Account confirmation', $msg->getSubject());
            $this->assertEquals($email, join('', array_keys($msg->getTo())));
            $this->assertStringContainsString('Confirm new account', $msg->getBody());
        });

        $response = $this->json('POST','/api/auth/register', [
            'name'                  => $name,
            'email'                 => $email,
            'password'              => '123456',
            'password_confirmation' => '123456',
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function register_account_confirmation()
    {
        $response = $this->json('GET', "api/auth/register/confirm-email/someemail/token/1111");
        $response->assertStatus(200);
        $response->assertJson(['status' => 'error']);

        $faker = Factory::create();
        $name = $faker->name;
        $email = $faker->unique()->safeEmail;
        $response = $this->json('POST','/api/auth/register', [
           'name'                  => $name,
           'email'                 => $email,
           'password'              => '123456',
           'password_confirmation' => '123456',
        ]);
        $response->assertStatus(200);
        if ($user = User::where('email', $email)->first()) {
            $response = $this->json('GET',"api/auth/register/confirm-email/$user->email/token/$user->verify_token");
            $response->assertStatus(200);
            $response->assertJsonStructure(['status', 'user', 'token']);
            //info(json_encode($response->getContent()));
        }

    }
}
