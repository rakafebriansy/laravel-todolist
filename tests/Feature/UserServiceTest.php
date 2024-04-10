<?php

namespace Tests\Feature;

use App\Services\UserService;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    private UserService $user_service;

    public function setUp():void
    {
        parent::setUp();
        DB::delete('DELETE FROM users');
        $this->user_service = $this->app->make(UserService::class);
    }
    public function testLoginSuccess()
    {
        $this->seed(UserSeeder::class);
        self::assertTrue($this->user_service->login('raka@gmail.com','rahasia'));
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
