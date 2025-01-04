@extends('layouts.app')

@section('content')
<div class="container mx-auto py-4">
    <h1 class="text-2xl font-bold mb-4">Liste des UEs</h1>
    <a href="{{ route('ues.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-200">Ajouter une UE</a>

    <table class="w-full mt-4 border border-gray-200">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-4 py-2">Code</th>
                <th class="border px-4 py-2">Nom</th>
                <th class="border px-4 py-2">Crédits</th>
                <th class="border px-4 py-2">Semestre</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ues as $ue)
                <tr>
                    <td class="border px-4 py-2">{{ $ue->code }}</td>
                    <td class="border px-4 py-2">{{ $ue->nom }}</td>
                    <td class="border px-4 py-2">{{ $ue->credits_ects }}</td>
                    <td class="border px-4 py-2">S{{ $ue->semestre }}</td>
                    <td class="border px-4 py-2 flex space-x-2">
                        <a href="{{ route('ues.edit', $ue->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-200">Modifier</a>
                        <form action="{{ route('ues.destroy', $ue->id) }}" method="POST" class="inline">
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
@endsection
