<div class="container mx-auto py-4">
    <h1 class="text-2xl font-bold mb-4">
        @isset($ue) Modifier une UE @else Créer une UE @endisset
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

    <form action="{{ isset($ue) ? route('ues.update', $ue->id) : route('ues.store') }}" method="POST" class="bg-white shadow-md rounded px-8 py-6">
        @csrf
        @isset($ue) @method('PUT') @endisset

        <!-- Code -->
        <div class="mb-4">
            <label for="code" class="block text-gray-700">Code</label>
            <input type="text" id="code" name="code" value="{{ old('code', $ue->code ?? '') }}" 
                   class="w-full px-4 py-2 border rounded" required>
        </div>

        <!-- Nom -->
        <div class="mb-4">
            <label for="nom" class="block text-gray-700">Nom</label>
            <input type="text" id="nom" name="nom" value="{{ old('nom', $ue->nom ?? '') }}" 
                   class="w-full px-4 py-2 border rounded" required>
        </div>

        <!-- Crédits ECTS -->
        <div class="mb-4">
            <label for="credits_ects" class="block text-gray-700">Crédits ECTS</label>
            <input type="number" id="credits_ects" name="credits_ects" 
                   value="{{ old('credits_ects', $ue->credits_ects ?? '') }}" 
                   class="w-full px-4 py-2 border rounded" min="1" max="30" required>
        </div>

        <!-- Semestre -->
        <div class="mb-4">
            <label for="semestre" class="block text-gray-700">Semestre</label>
            <select id="semestre" name="semestre" class="w-full px-4 py-2 border rounded" required>
                @for($i = 1; $i <= 6; $i++)
                    <option value="{{ $i }}" {{ (old('semestre', $ue->semestre ?? '') == $i) ? 'selected' : '' }}>
                        S{{ $i }}
                    </option>
                @endfor
            </select>
        </div>

        <!-- Bouton de soumission -->
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">
            @isset($ue) Mettre à jour @else Enregistrer @endisset
        </button>
    </form>
</div>
