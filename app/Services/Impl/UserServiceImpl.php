<?php

namespace App\Services\Impl;

use App\Services\UserService;

class UserServiceImpl implements UserService
{
    private array $users =[
        'raka' => '12345'
    ];
    public function login(string $user, string $password): bool
    {
        if(!isset($this->users[$user])) {
            return false;
        }
        $correct_password = $this->users[$user];
        return $password == $correct_password;
    }
}