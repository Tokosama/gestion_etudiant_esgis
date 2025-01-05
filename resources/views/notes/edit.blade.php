@extends('layouts.app')

@section('content')
<div class="container mx-auto py-4">
    <h1 class="text-2xl font-bold mb-4">Modifier la Note</h1>

    <form action="{{ route('notes.update', $note->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label for="etudiant_id" class="block font-medium">Étudiant</label>
            <select name="etudiant_id" id="etudiant_id" class="w-full border-gray-300 rounded">
                @foreach($etudiants as $etudiant)
                    <option value="{{ $etudiant->id }}" {{ $note->etudiant_id == $etudiant->id ? 'selected' : '' }}>
                        {{ $etudiant->prenom }} {{ $etudiant->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="ec_id" class="block font-medium">EC</label>
            <select name="ec_id" id="ec_id" class="w-full border-gray-300 rounded">
                @foreach($ecs as $ec)
                    <option value="{{ $ec->id }}" {{ $note->ec_id == $ec->id ? 'selected' : '' }}>
                        {{ $ec->code }} - {{ $ec->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="note" class="block font-medium">Note</label>
            <input type="number" name="note" id="note" class="w-full border-gray-300 rounded" value="{{ $note->note }}" min="0" max="20" step="0.01">
        </div>

        <div>
            <label for="session" class="block font-medium">Session</label>
            <select name="session" id="session" class="w-full border-gray-300 rounded">
                <option value="normale" {{ $note->session == 'normale' ? 'selected' : '' }}>Normale</option>
                <option value="rattrapage" {{ $note->session == 'rattrapage' ? 'selected' : '' }}>Rattrapage</option>
            </select>
        </div>

        <div>
            <label for="date_evaluation" class="block font-medium">Date d'Évaluation</label>
            <input type="date" name="date_evaluation" id="date_evaluation" class="w-full border-gray-300 rounded" value="{{ $note->date_evaluation }}">
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Mettre à Jour</button>
        <a href="{{ route('notes.index') }}" class="ml-4 text-gray-600 hover:underline">Annuler</a>
    </form>
</div>
@endsection
