<?php

namespace Tests\Feature;

use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function setUp():void
    {
        parent::setUp();
        DB::delete('DELETE FROM users');
    }
    public function testLoginForGuest()
    {
        $this->get('/login')->assertSeeText('Login');
    }
    public function testLoginForMember()
    {
        $this->withSession([
            'user' => 'raka'
        ])->get('login')->assertRedirect('/');
    }
    public function testDoLoginSuccess()
    {
        $this->seed(UserSeeder::class);
        $this->post('/login', [
            'user' => 'raka@gmail.com',
            'password' => 'rahasia'
        ])->assertRedirect('/')->assertSessionHas('user','raka@gmail.com');
    }
    public function testDoLoginValidationError()
    {
        $this->post('/login', [])->assertSeeText('User or password are required');
    }
    public function testDoLoginFailed()
    {
        $this->post('/login', [
            'user' => 'raka',
            'password' => '1223'
        ])->assertSeeText('User or password are invalid');
    }
    public function testDoLoginForUserAlreadyLogin()
    {
        $this->withSession([
            'user' => 'raka'
        ])->post('/login', [
            'user' => 'raka',
            'password' => '1223'
        ])->assertRedirect('/');
    }
    public function testDoLogoutForMember()
    {
        $this->withSession([
            'user' => 'raka'
        ])->post('/logout')->assertRedirect('/')->assertSessionMissing('user');
    }
    public function testDoLogoutForGuest()
    {
        $this->post('/logout')->assertRedirect('/login');
    }
}
