@extends('layouts.app')

@section('content')
<div class="container mx-auto py-4">
    <h1 class="text-2xl font-bold mb-4">Liste des Étudiants</h1>

    <!-- Formulaire pour sélectionner un semestre -->
    <form method="GET" action="{{ route('etudiants.index') }}" class="mb-4">
    <label for="semestre">Choisir et filtre le semestre dont vous voulez voir le resultats:</label>
    <select name="semestre" id="semestre" class="border rounded p-2">
        @for ($i = 1; $i <= 6; $i++) <!-- Ajustez le nombre de semestres si nécessaire -->
            <option value="{{ $i }}" {{ $semestre == $i ? 'selected' : '' }}>
                Semestre {{ $i }}
            </option>
        @endfor
    </select>
    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Filtrer</button>
</form>

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
            <td>
                <a href="{{ route('etudiant.resultats', $etudiant->id) }}" class="btn btn-primary">
                    Voir les résultats
                </a>
                <a href="{{ route('resultats.semestre', ['etudiantId' => $etudiant->id, 'semestre' => $semestre]) }}" class="btn btn-primary">
                    Voir les résultats du Semestre {{ $semestre }} pour {{$etudiant->nom}}
                </a>
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
@endsection