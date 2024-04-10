<?php

namespace Tests\Feature;

use Database\Seeders\TodoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TodolistControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        DB::delete('DELETE FROM todos');
    }
    public function testTodolist()
    {
        $this->seed([TodoSeeder::class]);
        $this->withSession([
            'user' => 'Raka'
        ])->get('/todolist')
            ->assertSeeText('1')->assertSeeText('Doing something')->assertSeeText('2')->assertSeeText('Bake a bread');
    }
    public function testAddTodoFailed()
    {
        $this->withSession([
            'user' => 'Raka',
        ])->post('/todolist',[])
            ->assertSeeText('Todo is required');
    }
    public function testAddTodoSuccess()
    {
        $this->withSession([
            'user' => 'Raka'
        ])->post('/todolist', [
            'todo' => 'Cooking'
        ])->assertRedirect('/todolist');
    }
    public function testRemoveTodo()
    {
        $this->withSession([
            'user' => 'Raka',
            'todolist' => [
                [
                    'id' => '1',
                    'todo' => 'Doing something'
                ],
                [
                    'id' => '2',
                    'todo' => 'Bake a bread'
                ]
            ]
        ])->post('/todolist/1/delete')
            ->assertRedirect('/todolist');
    }
}
