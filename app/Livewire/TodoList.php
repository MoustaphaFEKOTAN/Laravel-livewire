<?php
namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\tasks;

class TodoList extends Component
{
    use WithPagination;

    public $newTask = '';
    public $editingTaskId = null; // L'ID de la tâche en cours de modification
    public $editingTaskTitle = ''; // Le titre de la tâche en cours de modification

    // La méthode pour charger les tâches depuis la base de données
    public function loadTasks()
    {
        // Retourner directement la pagination pour l'utiliser dans la vue
        return tasks::orderBy('created_at', 'desc')->paginate(5);
    }

    // Validation pour ajouter une tâche
    public function addTask()
    {
        $this->validate([
            'newTask' => 'required|min:3|max:255',  // Validation : obligatoire, entre 3 et 255 caractères
        ]);

        tasks::create(['title' => $this->newTask]);
        $this->newTask = ''; // Réinitialiser le champ après ajout
    }

    // Toggle pour marquer une tâche comme complétée ou non
    public function toggleTask($taskId)
    {
        $task = tasks::find($taskId);
        if ($task) {
            $task->update(['completed' => !$task->completed]);
        }
    }

    // Suppression d'une tâche
    public function deleteTask($taskId)
    {
        $task = tasks::find($taskId);
        if ($task) {
            $task->delete();
        }
    }

    // Modifier le titre d'une tâche
    public function editTask($taskId)
    {
        $task = tasks::find($taskId);
        if ($task) {
            $this->editingTaskId = $taskId;
            $this->editingTaskTitle = $task->title;
        }
    }

    // Sauvegarder le changement de titre de la tâche
    public function updateTask()
    {
        $this->validate([
            'editingTaskTitle' => 'required|min:3|max:255',  // Validation : obligatoire, entre 3 et 255 caractères
        ]);

        $task = tasks::find($this->editingTaskId);
        if ($task) {
            $task->update(['title' => $this->editingTaskTitle]);
            $this->editingTaskId = null; // Réinitialiser l'ID de la tâche en cours de modification
            $this->editingTaskTitle = ''; // Réinitialiser le titre
        }
    }

    public function render()
    {
        // Utiliser la méthode loadTasks pour récupérer les tâches paginées et les passer à la vue
        return view('livewire.todolist', [
            'tasks' => $this->loadTasks(),  // Appel à loadTasks pour obtenir les tâches paginées
        ]);
    }
}
