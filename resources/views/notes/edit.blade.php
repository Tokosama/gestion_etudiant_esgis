@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6 px-4">
    <h1 class="text-3xl font-semibold text-gray-800 mb-6">Modifier les informations de l'étudiant</h1>

    <!-- Affichage des messages de session -->
    @if(session('success'))
        <div class="alert alert-success mb-4 p-4 bg-green-100 border border-green-400 text-green-800 rounded-md">
            {{ session('success') }}
        </div>
    @endif

    <!-- Formulaire de modification -->
    <form action="{{ route('etudiants.update', $etudiant->id) }}" method="POST" class="bg-white shadow-lg rounded-lg p-6">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="numero_etudiant" class="block text-lg font-medium text-gray-700">Numéro Étudiant</label>
            <input type="text" name="numero_etudiant" id="numero_etudiant" value="{{ old('numero_etudiant', $etudiant->numero_etudiant) }}" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
        </div>

        <div class="mb-4">
            <label for="nom" class="block text-lg font-medium text-gray-700">Nom</label>
            <input type="text" name="nom" id="nom" value="{{ old('nom', $etudiant->nom) }}" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
        </div>

        <div class="mb-4">
            <label for="prenom" class="block text-lg font-medium text-gray-700">Prénom</label>
            <input type="text" name="prenom" id="prenom" value="{{ old('prenom', $etudiant->prenom) }}" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
        </div>

        <div class="mb-4">
            <label for="niveau" class="block text-lg font-medium text-gray-700">Niveau</label>
            <select name="niveau" id="niveau" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                <option value="L1" {{ $etudiant->niveau == 'L1' ? 'selected' : '' }}>L1</option>
                <option value="L2" {{ $etudiant->niveau == 'L2' ? 'selected' : '' }}>L2</option>
                <option value="L3" {{ $etudiant->niveau == 'L3' ? 'selected' : '' }}>L3</option>
            </select>
        </div>

        <button type="submit" class="bg-green-300 text-white px-4 py-2 rounded hover:bg-green-400">Mettre à jour</button>
        </form>
</div>
@endsection
