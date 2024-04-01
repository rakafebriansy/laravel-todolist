<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    private UserService $user_service;
    public function __construct(UserService $user_service)
    {
        $this->user_service = $user_service;
    }
    public function login(): Response
    {
        return response()->view('user.login', [
            'title' => 'Login'
        ]);
    }
    public function doLogin(Request $request): Response|RedirectResponse
    {
        $user = $request->input('user');
        $password = $request->input('password');
        if(empty($user) || empty($password)){
            return response()->view('user.login', [
                'title' => 'Login',
                'error' => 'User or password are required'
            ]);
        }
        if($this->user_service->login($user,$password)){
            $request->session()->put('user',$user);
            return redirect('/');
        }
        return response()->view('user.login', [
            'title' => 'Login',
            'error' => 'User or password are invalid'
        ]);
    }
    public function doLogout(Request $request): RedirectResponse
    {
        $request->session()->forget('user');
        return redirect('/');
    }
}
