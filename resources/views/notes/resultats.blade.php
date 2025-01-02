@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-2xl font-semibold mb-6">Résultats Globaux par Semestre</h1>
    
    <table class="min-w-full border-collapse">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">UE</th>
                <th class="py-2 px-4 border-b">Moyenne</th>
                <th class="py-2 px-4 border-b">Crédits ECTS</th>
                <th class="py-2 px-4 border-b">Validation</th>
            </tr>
        </thead>
        <tbody>
            @foreach($resultats as $data)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $data['ue']->code }} - {{ $data['ue']->nom }}</td>
                    <td class="py-2 px-4 border-b">{{ number_format($data['moyenne'], 2) }}</td>
                    <td class="py-2 px-4 border-b">{{ $data['credits_ects'] }}</td>
                    <td class="py-2 px-4 border-b">
    @if ($data['valide'])
        <span class="text-green-500">Validée</span>
    @elseif ($data['valide_par_compensation'])
        <span class="text-yellow-500">Validée par compensation</span>
    @else
        <span class="text-red-500">Non validée</span>
    @endif
</td>

                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-6">
        <h2 class="text-xl">Crédits ECTS acquis : {{ $creditsAcquis }}</h2>
    </div>
</div>
@endsection
