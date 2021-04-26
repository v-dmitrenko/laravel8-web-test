<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations, ApiEnvTrait;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->createEnvironment();
    }
}
