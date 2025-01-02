@extends('layouts.app')

@section('content')
<div class="container mx-auto py-4">
    <h1 class="text-2xl font-bold mb-4">Liste des ECs</h1>
    <a href="{{ route('ecs.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Ajouter un EC</a>

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
                    <td class="border px-4 py-2">
                        <a href="{{ route('ecs.edit', $ec->id) }}" class="text-blue-500">Modifier</a> |
                        <form action="{{ route('ecs.destroy', $ec->id) }}" method="POST" class="inline">
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
