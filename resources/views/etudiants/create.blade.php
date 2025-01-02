@extends('layouts.app')

@section('content')
<div class="container mx-auto py-4">
    <h1 class="text-2xl font-bold mb-4">Créer un Étudiant</h1>
    <form action="{{ route('etudiants.store') }}" method="POST" class="bg-white shadow-md rounded px-8 py-6">
        @csrf
        @include('etudiants.form')
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Enregistrer</button>
    </form>
</div>
@endsection
