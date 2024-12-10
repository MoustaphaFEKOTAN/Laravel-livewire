@extends('layouts.app')

@section('content')
    <div class="p-4">
        <h1 class="text-xl font-bold mb-4">Bienvenue dans le tableau de bord</h1>
        <p>Voici votre gestionnaire de tâches :</p>
        
        <!-- Appel du composant TodoList Livewire ici -->
        @livewire('todo-list')
    </div>
@endsection
