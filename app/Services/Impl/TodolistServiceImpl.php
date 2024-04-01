<?php

namespace App\Services\Impl;

use  App\Services\TodolistService;
use Illuminate\Support\Facades\Session;

class TodolistServiceImpl implements TodolistService
{
    public function saveTodo(string $id, string $todo): void
    {
        if(!Session::exists(['todolist'])) {
            Session::put('todolist', []);
        }
        Session::push('todolist', [
            'id' => $id,
            'todo' => $todo
        ]);
    }
    public function getTodolist(): array
    {
        return Session::get('todolist',[]);
    }
    public function removeTodo(string $remove_id): void
    {
        $todolist = Session::get('todolist');
        foreach($todolist as $id => $todo) {
            if($todo['id'] == $remove_id){
                unset($todolist[$id]); break;
            }
        }
        Session::put('todolist',$todolist);   
    }
}