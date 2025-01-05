@extends('layouts.app')

@section('content')
<div class="container mx-auto py-4">
    <h1 class="text-2xl font-bold mb-4">Liste des ECs</h1>
    <a href="{{ route('ecs.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-200">Ajouter un EC</a>

    <table class="w-full mt-4 border border-gray-200">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-4 py-2">Code</th>
                <th class="border px-4 py-2">Nom</th>
                <th class="border px-4 py-2">Coefficient</th>
                <th class="border px-4 py-2">UE Associée</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ecs as $ec)
                <tr>
                    <td class="border px-4 py-2">{{ $ec->code }}</td>
                    <td class="border px-4 py-2">{{ $ec->nom }}</td>
                    <td class="border px-4 py-2">{{ $ec->coefficient }}</td>
                    <td class="border px-4 py-2">{{ $ec->ue->nom }}</td>
                    <td class="border px-4 py-2 flex space-x-2">
                        <a href="{{ route('ecs.edit', $ec->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-200">Modifier</a>
                        <form action="{{ route('ecs.destroy', $ec->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition duration-200" onclick="return confirm('Êtes-vous sûr ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<a href="{{ route('home') }}" class="mt-4 bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600 transition">Accueil</a>
@endsection
