<?php

namespace Tests\Feature;

use App\Services\TodolistService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class TodolistServiceTest extends TestCase
{
    private TodolistService $todolist_service;
    protected function setUp(): void
    {
        parent::setUp();
        $this->todolist_service = $this->app->make(TodolistService::class);
    }
    public function testTodolistNotNull()
    {
        self::assertNotNull($this->todolist_service);
    }
    public function testSaveTodo()
    {
        $this->todolist_service->saveTodo('1','Raka');
        $todolist = Session::get('todolist');
        foreach ($todolist as $todo) {
            self::assertEquals('1',$todo['id']);
            self::assertEquals('Raka',$todo['todo']);
        }
    }
    public function testGetTodolistEmpty()
    {
        self::assertEquals([],$this->todolist_service->getTodolist());
    }
    public function testGetTodolist()
    {
        $expected = [
            [
                'id' => '1',
                'todo' => 'Raka'
            ],
            [
                'id' => '2',
                'todo' => 'Karen'
            ],
        ];
        $this->todolist_service->saveTodo('1','Raka');
        $this->todolist_service->saveTodo('2','Karen');
        
        self::assertEquals($expected, $this->todolist_service->getTodolist());
    }
    public function testRemoveTodo()
    {
        $this->todolist_service->saveTodo('1','Jefferson');
        $this->todolist_service->saveTodo('2','Bella');
        self::assertEquals(2,  sizeof($this->todolist_service->getTodolist()));
        
        $this->todolist_service->removeTodo('3');
        self::assertEquals(2,  sizeof($this->todolist_service->getTodolist()));

        $this->todolist_service->removeTodo('1');
        self::assertEquals(1,  sizeof($this->todolist_service->getTodolist()));

        $this->todolist_service->removeTodo('2');
        self::assertEquals(0,  sizeof($this->todolist_service->getTodolist()));
    }
}
