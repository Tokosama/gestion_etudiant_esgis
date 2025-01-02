@extends('layouts.app')

@section('content')
<div class="container mx-auto py-4">
    <h1 class="text-2xl font-bold mb-4">Liste des Étudiants</h1>
    <a href="{{ route('etudiants.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Ajouter un Étudiant</a>

    <table class="w-full mt-4 border border-gray-200">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-4 py-2">Numéro</th>
                <th class="border px-4 py-2">Nom</th>
                <th class="border px-4 py-2">Prénom</th>
                <th class="border px-4 py-2">Niveau</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($etudiants as $etudiant)
                <tr>
                    <td class="border px-4 py-2">{{ $etudiant->numero_etudiant }}</td>
                    <td class="border px-4 py-2">{{ $etudiant->nom }}</td>
                    <td class="border px-4 py-2">{{ $etudiant->prenom }}</td>
                    <td class="border px-4 py-2">{{ $etudiant->niveau }}</td>
                    <td class="border px-4 py-2">
                        <a href="{{ route('etudiants.edit', $etudiant->id) }}" class="text-blue-500">Modifier</a> |
                        <form action="{{ route('etudiants.destroy', $etudiant->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500" onclick="return confirm('Êtes-vous sûr ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
