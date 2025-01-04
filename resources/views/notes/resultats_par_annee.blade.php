@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-2xl font-semibold mb-6">Résultats de l'étudiant : {{ $etudiant->nom }} {{ $etudiant->prenom }} {{$etudiant->niveau}}</h1>

    @foreach($resultatsParSemestre as $semestre => $ues)
        <h2 class="text-xl mb-4">Semestre {{ $semestre }}</h2>

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
                @foreach($ues as $data)
                    <tr>
                        <td class="py-2 px-4 border-b">{{ $data['ue']->code }} - {{ $data['ue']->nom }}</td>
                        <td class="py-2 px-4 border-b">{{ number_format($data['moyenne'], 2) }}</td>

                        <td class="py-2 px-4 border-b">{{ $data['credits_ects'] }}</td>
                       

                        <td class="py-2 px-4 border-b">
                            @if($data['valide'])
                                <span class="text-green-500">Validée</span>
                            
                            @else
                                <span class="text-red-500">Non validée</span>
                            @endif
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach

    <div class="mt-4">
        
        <p>Total des crédits obtenus : {{ $creditsAcquis }}</p>
        <p>Total des crédits de l'année : {{ $creditsTotaux }}</p>
        <p>Crédits nécessaires pour passer à l'année supérieure : 
            {{ $creditsTotaux }} (équivalent au total des crédits de l'année)
        </p>
    
      
        <h3 class="text-lg">
            Passage à l'année suivante : 
            @if($creditsTotaux ===$creditsAcquis)
                <span class="text-green-500">Oui</span>
            @else
                <span class="text-red-500">Non</span>
            @endif
        </h3>
    </div>
    
</div>

@endsection
