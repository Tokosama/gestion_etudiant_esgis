<div class="container mx-auto py-4">
    <h1 class="text-2xl font-bold mb-4">
        @isset($ec) Modifier un EC @else Créer un EC @endisset
    </h1>

    <!-- Affichage des messages d'erreur -->
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 mb-4 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    

    <form action="{{ isset($ec) ? route('ecs.update', $ec->id) : route('ecs.store') }}" method="POST" class="bg-white shadow-md rounded px-8 py-6">
        @csrf
        @isset($ec) @method('PUT') @endisset

        <!-- Code -->
        <div class="mb-4">
    <label for="code" class="block text-gray-700">Code</label>
    <input type="text" id="code" name="code" value="{{ old('code', $ec->code ?? '') }}" 
           class="w-full px-4 py-2 border rounded" required>
    <p class="text-xs text-gray-500">Format attendu : ECxx (ex : EC01)</p> <!-- Message format -->
</div>


        <!-- Nom -->
        <div class="mb-4">
            <label for="nom" class="block text-gray-700">Nom</label>
            <input type="text" id="nom" name="nom" value="{{ old('nom', $ec->nom ?? '') }}" 
                   class="w-full px-4 py-2 border rounded" required>
        </div>

        <!-- Coefficient -->
        <div class="mb-4">
            <label for="coefficient" class="block text-gray-700">Coefficient</label>
            <input type="number" id="coefficient" name="coefficient" 
                   value="{{ old('coefficient', $ec->coefficient ?? '') }}" 
                   class="w-full px-4 py-2 border rounded" min="1" max="5" required>
        </div>

        <!-- UE Associée -->
        <div class="mb-4">
            <label for="ue_id" class="block text-gray-700">UE Associée</label>
            <select id="ue_id" name="ue_id" class="w-full px-4 py-2 border rounded" required>
                @foreach($ues as $ue)
                    <option value="{{ $ue->id }}" {{ (old('ue_id', $ec->ue_id ?? '') == $ue->id) ? 'selected' : '' }}>
                        {{ $ue->code }} - {{ $ue->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Bouton de soumission -->
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">
            @isset($ec) Mettre à jour @else Enregistrer @endisset
        </button>
    </form>
</div>
