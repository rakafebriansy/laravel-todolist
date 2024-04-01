<?php

namespace App\Http\Controllers;

use App\Services\TodolistService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TodolistController extends Controller
{
    private TodolistService $todolist_service;
    public function __construct(TodolistService $todolist_service)
    {
        $this->todolist_service = $todolist_service;        
    }
    public function todolist(Request $request): Response
    {
        $todolist = $this->todolist_service->getTodolist();
        return response()->view('todolist.todolist',[
            'title' => 'Todolist',
            'todolist' => $todolist
        ]);
    }
    public function addTodo(Request $request): RedirectResponse
    {
        $todo = $request->input('todo');
        if(empty($todo)) {
            $todolist = $this->todolist_service->getTodolist();
            return response()->view('todolist.todolist', [
                'title' => 'Todolist',
                'todolist' => $todolist,
                'error' => 'Todo is required'
            ]);
        }
        $this->todolist_service->saveTodo(uniqid(), $todo);
        return redirect()->action([TodolistController::class, 'todolist']);
    }
    public function removeTodo(Request $request, string $id): RedirectResponse
    {
        $this->todolist_service->removeTodo($id);
        return redirect()->action([TodolistController::class, 'todolist']);
    }
}
