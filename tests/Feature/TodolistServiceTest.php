<?php

namespace Tests\Feature;

use App\Services\TodolistService;
use Database\Seeders\TodoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Testing\Assert;
use Tests\TestCase;

class TodolistServiceTest extends TestCase
{
    private TodolistService $todolist_service;
    protected function setUp(): void
    {
        parent::setUp();
        DB::delete('DELETE FROM todos');
        $this->todolist_service = $this->app->make(TodolistService::class);
    }
    public function testTodolistNotNull()
    {
        self::assertNotNull($this->todolist_service);
    }
    public function testSaveTodo()
    {
        $this->todolist_service->saveTodo('1','Raka');
        $todolist = $this->todolist_service->getTodolist();
        self::assertNotNull($todolist);
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
        $this->seed(TodoSeeder::class);
        $expected = [
            [
                'id' => '1',
                'todo' => 'Doing something'
            ],
            [
                'id' => '2',
                'todo' => 'Bake a bread'
            ],
        ];
        
        Assert::assertArraySubset($expected, $this->todolist_service->getTodolist());
    }
    public function testRemoveTodo()
    {
        $this->seed(TodoSeeder::class);

        self::assertEquals(2,  sizeof($this->todolist_service->getTodolist()));
        
        $this->todolist_service->removeTodo('3');
        self::assertEquals(2,  sizeof($this->todolist_service->getTodolist()));

        $this->todolist_service->removeTodo('1');
        self::assertEquals(1,  sizeof($this->todolist_service->getTodolist()));

        $this->todolist_service->removeTodo('2');
        self::assertEquals(0,  sizeof($this->todolist_service->getTodolist()));
    }
}
