<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\tasks;
use Illuminate\Validation\ValidationException;

class TodoList extends Component
{
    public $newTask = '';
    public $tasks = [];
    public $editingTaskId = null;  // Pour suivre l'ID de la tâche en cours de modification
    public $editingTaskTitle = ''; // Pour le titre de la tâche en cours de modification

    public function mount()
    {
        $this->loadTasks();
    }

    public function loadTasks()
    {
        $this->tasks = tasks::orderBy('created_at', 'desc')->get();
    }

    // Validation pour ajouter une tâche
    public function addTask()
    {
        $this->validate([
            'newTask' => 'required|min:3|max:255',  // Validation : obligatoire, entre 3 et 255 caractères
        ]);

        tasks::create(['title' => $this->newTask]);
        $this->newTask = '';
        $this->loadTasks();
    }

    // Toggle pour marquer une tâche comme complétée ou non
    public function toggleTask($taskId)
    {
        $task = tasks::find($taskId);
        if ($task) {
            $task->update(['completed' => !$task->completed]);
            $this->loadTasks();
        }
    }

    // Suppression d'une tâche
    public function deleteTask($taskId)
    {
        $task = tasks::find($taskId);
        if ($task) {
            $task->delete();
            $this->loadTasks();
        }
    }

    // Modifier le titre d'une tâche
    public function editTask($taskId)
    {
        $task = tasks::find($taskId);
        if ($task) {
            $this->editingTaskId = $taskId;
            $this->editingTaskTitle = $task->title;  // Mettre le titre actuel dans le champ d'édition
        }
    }

    // Sauvegarder le changement de titre
    public function updateTask()
    {
        $this->validate([
            'editingTaskTitle' => 'required|min:3|max:255',  // Validation : obligatoire, entre 3 et 255 caractères
        ]);

        $task = tasks::find($this->editingTaskId);
        if ($task) {
            $task->update(['title' => $this->editingTaskTitle]);
            $this->editingTaskId = null;  // Réinitialiser l'ID de la tâche en cours de modification
            $this->editingTaskTitle = '';  // Réinitialiser le titre
            $this->loadTasks();
        }
    }

    public function render()
    {
        return view('livewire.todolist');
    }
}
