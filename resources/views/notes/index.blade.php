@extends('layouts.app')

@section('content')
<div class="container mx-auto py-4">
    <h1 class="text-2xl font-bold mb-4">Liste des Notes</h1>
    <a href="{{ route('notes.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-200">Ajouter une Note</a>


    <!-- Affichage des messages de session -->
    @if(session('error'))
        <div class="alert alert-danger mb-4 p-4 bg-red-100 border border-red-400 text-red-800 rounded-md">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success mb-4 p-4 bg-green-100 border border-green-400 text-green-800 rounded-md">
            {{ session('success') }}
        </div>
    @endif

    @if(session('info'))
        <div class="alert alert-info mb-4 p-4 bg-blue-100 border border-blue-400 text-blue-800 rounded-md">
            {{ session('info') }}
        </div>
    @endif

    <!-- Table des notes -->
    <table class="w-full mt-4 border border-gray-200">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-4 py-2">Étudiant</th>
                <th class="border px-4 py-2">EC</th>
                <th class="border px-4 py-2">Note</th>
                <th class="border px-4 py-2">Session</th>
                <th class="border px-4 py-2">Date d'Évaluation</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($notes as $note)
                <tr>
                    <td class="border px-4 py-2">{{ $note->etudiant->prenom }} {{ $note->etudiant->nom }}</td>
                    <td class="border px-4 py-2">{{ $note->ec->code }} - {{ $note->ec->nom }}</td>
                    <td class="border px-4 py-2">{{ $note->note }}</td>
                    <td class="border px-4 py-2">{{ $note->session }}</td>
                    <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($note->date_evaluation)->format('d/m/Y') }}</td>
                    <td class="border px-4 py-2 flex space-x-4">
                        <!-- Boutons Modifier et Supprimer -->
                        <a href="{{ route('notes.edit', $note->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-200">
                            Modifier
                        </a>
                        <form action="{{ route('notes.destroy', $note->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition duration-200" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette note ?')">
                                Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
