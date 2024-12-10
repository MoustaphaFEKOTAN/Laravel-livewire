<?php

namespace App\Livewire;


use Livewire\Component;
use App\Models\tasks;


class TodoList extends Component
{
    public $newTask = '';
    public $tasks = [];

    public function mount()
    {
        $this->loadTasks();
    }

    public function loadTasks()
    {
        $this->tasks = tasks::orderBy('created_at', 'desc')->get();
    }

    public function addTask()
    {
        if ($this->newTask != '') {
            tasks::create(['title' => $this->newTask]);
            $this->newTask = '';
            $this->loadTasks();
        }
    }

    public function toggleTask($taskId)
    {
        $task = tasks::find($taskId);
        if ($task) {
            $task->update(['completed' => !$task->completed]);
            $this->loadTasks();
        }
    }

    public function deleteTask($taskId)
    {
        $task = tasks::find($taskId);
        if ($task) {
            $task->delete();
            $this->loadTasks();
        }
    }

    public function render()
    {
        return view('livewire.todolist'); 
    }
}
