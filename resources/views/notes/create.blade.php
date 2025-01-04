@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-2xl font-semibold mb-6">Saisir les Notes</h1>

    <!-- Formulaire de sélection de l'étudiant -->
    <form method="GET" action="{{ route('notes.create') }}">
        <div class="mb-4">
            <label for="etudiant_id" class="block text-sm font-medium text-gray-700">Sélectionner l'Étudiant</label>
            <select name="etudiant_id" id="etudiant_id" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" onchange="this.form.submit()">
                <option value="">-- Choisir un étudiant --</option>
                @foreach($etudiants as $etudiant)
                    <option value="{{ $etudiant->id }}" {{ request('etudiant_id') == $etudiant->id ? 'selected' : '' }}>
                        {{ $etudiant->nom }} {{ $etudiant->prenom }} ({{ $etudiant->niveau }})
                    </option>
                @endforeach
            </select>
        </div>
    </form>

    <!-- Vérification si un étudiant est sélectionné et afficher les ECs -->
@if(request('etudiant_id') && $ecs->isNotEmpty())
<form action="{{ route('notes.store') }}" method="POST">
    @csrf

    <!-- Ajouter un champ caché pour l'ID de l'étudiant -->
    <input type="hidden" name="etudiant_id" value="{{ request('etudiant_id') }}">

    <!-- Sélection de l'EC pour l'étudiant choisi -->
    <div class="mb-4">
        <label for="ec_id" class="block text-sm font-medium text-gray-700">Sélectionner l'EC</label>
        <select name="ec_id" id="ec_id" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
            @foreach($ecs as $ec)
                <option value="{{ $ec->id }}">{{ $ec->code }} - {{ $ec->nom }}</option>
            @endforeach
        </select>
    </div>

    <!-- Sélection de la note -->
    <div class="mb-4">
        <label for="note" class="block text-sm font-medium text-gray-700">Note</label>
        <input type="number" name="note" id="note" min="0" max="20" step="0.25" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
    </div>

    <!-- Sélection de la session -->
    <div class="mb-4">
        <label for="session" class="block text-sm font-medium text-gray-700">Session</label>
        <select name="session" id="session" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
            <option value="normale">Session Normale</option>
            <option value="rattrapage">Rattrapage</option>
        </select>
    </div>

    <!-- Sélection de la date d'évaluation -->
    <div class="mb-4">
        <label for="date_evaluation" class="block text-sm font-medium text-gray-700">Date d'Évaluation</label>
        <input type="date" name="date_evaluation" id="date_evaluation" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
    </div>

    <!-- Bouton de soumission -->
    <button type="submit" class="bg-blue-500 text-white p-2 rounded-md">Enregistrer</button>
</form>
@elseif(request('etudiant_id') && $ecs->isEmpty())
<div class="mb-4">
    <p class="text-red-500">Aucun EC disponible pour l'étudiant sélectionné.</p>
</div>
@endif

</div>
@endsection
