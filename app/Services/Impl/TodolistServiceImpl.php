<?php

namespace App\Services\Impl;

use App\Models\Todo;
use  App\Services\TodolistService;
use Illuminate\Support\Facades\Session;

class TodolistServiceImpl implements TodolistService
{
    public function saveTodo(string $id, string $todo): void
    {
        $todo = new Todo([
            'id' => $id,
            'todo' => $todo
        ]);
    }
    public function getTodolist(): array
    {
        return Todo::query()->get()->toArray();
    }
    public function removeTodo(string $remove_id): void
    {
        $todo = Todo::query()->find($remove_id);
        if($todo != null) $todo->delete();
    }
}