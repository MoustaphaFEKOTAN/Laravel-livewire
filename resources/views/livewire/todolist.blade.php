
<div class="p-4">
    <h1 class="text-lg font-bold mb-4">Liste de tâches</h1>

    <!-- Ajouter une tâche -->
    <form wire:submit.prevent="addTask" class="mb-4">
        <input 
            type="text" 
            wire:model="newTask" 
            placeholder="Nouvelle tâche"
            class="border rounded p-2 w-full"
        />
        <button 
            type="submit"
            class="bg-blue-500 text-white px-4 py-2 rounded mt-2"
        >
            Ajouter
        </button>
    </form>

    <!-- Liste des tâches -->
    <ul class="list-disc ml-4">
        @foreach($tasks as $task)
            <li class="flex items-center justify-between mb-2">
                <div>
                    <input 
                        type="checkbox" 
                        wire:click="toggleTask({{ $task->id }})"
                        {{ $task->completed ? 'checked' : '' }}
                        class="mr-2"
                    />
                    <span class="{{ $task->completed ? 'line-through text-gray-500' : '' }}">
                        {{ $task->title }}
                    </span>
                </div>
                <!-- Bouton de modification -->
                <button 
                    wire:click="editTask({{ $task->id }})"
                    class="bg-yellow-500 text-white px-2 py-1 rounded"
                >
                    Modifier
                </button>
                <!-- Bouton de suppression -->
                <button 
                    wire:click="deleteTask({{ $task->id }})"
                    class="bg-red-500 text-white px-2 py-1 rounded"
                >
                    Supprimer
                </button>
            </li>
        @endforeach
    </ul>

    <!-- Formulaire d'édition du titre -->
    @if($editingTaskId)
    <div class="mt-4">
        <h2 class="text-lg font-bold mb-2">Modifier la tâche</h2>
        <input 
            type="text" 
            wire:model="editingTaskTitle" 
            class="border rounded p-2 w-full"
        />
        <button 
            wire:click="updateTask"
            class="bg-blue-500 text-white px-4 py-2 rounded mt-2"
        >
            Sauvegarder
        </button>
        <button 
            wire:click="$set('editingTaskId', null)"
            class="bg-gray-500 text-white px-4 py-2 rounded mt-2"
        >
            Annuler
        </button>
    </div>
    @endif
</div>

