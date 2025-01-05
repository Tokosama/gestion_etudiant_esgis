@extends('layouts.app')

@section('content')
<div class="container mx-auto py-4">
    <h1 class="text-2xl font-bold mb-4">Liste des Étudiants</h1>
    <a href="{{ route('etudiants.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-200">Ajouter un Étudiant</a>

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
            @forelse($etudiants as $etudiant)
                <tr>
                    <td class="border px-4 py-2">{{ $etudiant->numero_etudiant }}</td>
                    <td class="border px-4 py-2">{{ $etudiant->nom }}</td>
                    <td class="border px-4 py-2">{{ $etudiant->prenom }}</td>
                    <td class="border px-4 py-2">{{ $etudiant->niveau }}</td>
                    <td class="border px-4 py-2">
                        <a href="{{ route('etudiant.resultats', $etudiant->id) }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition duration-200">
                            Voir les résultats
                        </a>
                    </td>
                    <td class="border px-4 py-2 flex space-x-2">
                        <a href="{{ route('etudiants.edit', $etudiant->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-200">Modifier</a>
                        <form action="{{ route('etudiants.destroy', $etudiant->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition duration-200" onclick="return confirm('Êtes-vous sûr ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-gray-500 py-4">Aucun étudiant trouvé.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $etudiants->links('pagination::tailwind') }}
    </div>

    <div class="mt-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-6">
            @if ($etudiants->count() > 0)
                <a href="{{ route('etudiants.show', $etudiant->id) }}" 
                   class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded block text-center">
                    Consultez la page pour voir les résultats par semestre
                </a>
            @endif
        </div>
    </div>
</div>
<a href="{{ route('home') }}" class="mt-4 bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600 transition">Accueil</a>
@endsection
