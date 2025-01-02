<div class="mb-4">
    <label for="numero_etudiant" class="block text-gray-700">Numéro Étudiant</label>
    <input type="text" id="numero_etudiant" name="numero_etudiant" 
           value="{{ old('numero_etudiant', $etudiant->numero_etudiant ?? '') }}" 
           class="w-full px-4 py-2 border rounded" required>
</div>
<div class="mb-4">
    <label for="nom" class="block text-gray-700">Nom</label>
    <input type="text" id="nom" name="nom" value="{{ old('nom', $etudiant->nom ?? '') }}" 
           class="w-full px-4 py-2 border rounded" required>
</div>
<div class="mb-4">
    <label for="prenom" class="block text-gray-700">Prénom</label>
    <input type="text" id="prenom" name="prenom" value="{{ old('prenom', $etudiant->prenom ?? '') }}" 
           class="w-full px-4 py-2 border rounded" required>
</div>
<div class="mb-4">
    <label for="niveau" class="block text-gray-700">Niveau</label>
    <select id="niveau" name="niveau" class="w-full px-4 py-2 border rounded" required>
        <option value="L1" {{ (old('niveau', $etudiant->niveau ?? '') == 'L1') ? 'selected' : '' }}>L1</option>
        <option value="L2" {{ (old('niveau', $etudiant->niveau ?? '') == 'L2') ? 'selected' : '' }}>L2</option>
        <option value="L3" {{ (old('niveau', $etudiant->niveau ?? '') == 'L3') ? 'selected' : '' }}>L3</option>
    </select>
</div>
