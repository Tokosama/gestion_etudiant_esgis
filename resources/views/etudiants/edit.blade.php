@extends('layouts.app')

@section('content')
<div class="container mx-auto py-4">
    <h1 class="text-2xl font-bold mb-4">Modifier un Étudiant</h1>
    <form action="{{ route('etudiants.update', $etudiant->id) }}" method="POST" class="bg-white shadow-md rounded px-8 py-6">
        @csrf
        @method('PUT')
        @include('etudiants.form')
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Mettre à jour</button>
    </form>
</div>
@endsection
