<?php

namespace Tests;

use App\Models\User;
use JWTAuth;

trait ApiEnvTrait
{
    public $user = null;
    public $userPassword = '123456';
    public $userMail = 'john.doe@test.com';
    public $userName = 'john.doe';
    public $headers = null;
    public $token = null;

    public function createEnvironment()
    {
        $this->removeEnvironment();

        $this->user = User::create([
            'name'     => $this->userName,
            'verified' => 1,
            'email'    => $this->userMail,
            'password' => bcrypt($this->userPassword),
            'status'   => User::STATUS_ACTIVE,
        ]);

        $this->token = JWTAuth::attempt(['email' => $this->userMail, 'password' => $this->userPassword,]);
        $this->headers = ['Authorization' => 'Bearer '.$this->token];
    }

    private function removeEnvironment()
    {
        if ($this->user) {
            User::where('id', $this->user->id)->delete();
            $this->user = null;
        }
    }
}
