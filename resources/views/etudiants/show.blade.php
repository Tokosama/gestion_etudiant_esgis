@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6 px-4">
    <h1 class="text-3xl font-semibold text-gray-800 mb-6">Liste des Étudiants</h1>

    <!-- Formulaire pour sélectionner un semestre -->
    <form method="GET" action="{{ route('etudiants.index') }}" class="mb-6 bg-white shadow-lg rounded-lg p-6">
        <label for="semestre" class="block text-lg font-medium text-gray-700 mb-2">Choisir et filtrer le semestre :</label>
        <div class="flex items-center space-x-4">
            <select name="semestre" id="semestre" class="border border-gray-300 rounded-lg p-3 text-gray-700 focus:ring-blue-500 focus:border-blue-500">
                @for ($i = 1; $i <= 6; $i++) <!-- Ajustez le nombre de semestres si nécessaire -->
                    <option value="{{ $i }}" {{ $semestre == $i ? 'selected' : '' }}>Semestre {{ $i }}</option>
                @endfor
            </select>
            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition duration-200">Filtrer</button>
        </div>
    </form>

    <div class="overflow-x-auto bg-white shadow-lg rounded-lg p-4">
        <table class="w-full border-separate border-spacing-0">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border-b px-4 py-3 text-left text-gray-600">Numéro</th>
                    <th class="border-b px-4 py-3 text-left text-gray-600">Nom</th>
                    <th class="border-b px-4 py-3 text-left text-gray-600">Prénom</th>
                    <th class="border-b px-4 py-3 text-left text-gray-600">Niveau</th>
                    <th class="border-b px-4 py-3 text-left text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($etudiants as $etudiant)
                    <tr class="hover:bg-gray-50">
                        <td class="border-b px-4 py-3">{{ $etudiant->numero_etudiant }}</td>
                        <td class="border-b px-4 py-3">{{ $etudiant->nom }}</td>
                        <td class="border-b px-4 py-3">{{ $etudiant->prenom }}</td>
                        <td class="border-b px-4 py-3">{{ $etudiant->niveau }}</td>
                        <td class="border-b px-4 py-3 flex space-x-4">
                            <a href="{{ route('resultats.semestre', ['etudiantId' => $etudiant->id, 'semestre' => $semestre]) }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-200">Voir les résultats du Semestre {{ $semestre }} pour {{ $etudiant->nom }}</a>
                            <a href="{{ route('etudiant.resultats', $etudiant->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-200">Voir les résultats</a>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-gray-500 py-4">
                            Aucun étudiant trouvé pour ce semestre.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
