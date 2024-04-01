<?php

namespace Tests\Feature;

use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    private UserService $user_service;

    public function setUp():void
    {
        parent::setUp();
        $this->user_service = $this->app->make(UserService::class);
    }
    public function testLoginSuccess()
    {
        self::assertTrue($this->user_service->login('raka','12345'));
    }
    public function testLoginNotFound()
    {
        self::assertFalse($this->user_service->login('rina','12345'));
    }
    public function testLoginWrongPassword()
    {
        self::assertFalse($this->user_service->login('raka','1111'));
    }
}
