<!-- resources/views/notes/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mx-auto py-4">
    <h1 class="text-2xl font-bold mb-4">Liste des Notes</h1>

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
                    <td class="border px-4 py-2">
                       
                    </td>
                    <td class="border px-4 py-2">
    @if ($note->note === null)
        <span class="text-red-500">Note manquante</span>
    @else
        {{ $note->note }}
    @endif
</td>

                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
