<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Saisie de Notes</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <header class="bg-green-500 text-white p-4">
        <h1 class="text-center text-2xl font-bold">Saisie de Notes</h1>
        <nav class="flex justify-center space-x-4 mt-2">
            <a href="index" class="hover:underline">Accueil</a>
            <a href="ue" class="hover:underline">Gestion des UEs</a>
            <a href="notes" class="hover:underline">Gestion des Notes</a>
            <a href="resultats" class="hover:underline">Résultats</a>
        </nav>
    </header>
    <main class="p-8">
        <form action="/route/notes/store" method="POST" class="max-w-lg mx-auto bg-white p-8 shadow-md rounded">
            <div class="mb-4">
                <label for="etudiant" class="block text-gray-700">Étudiant</label>
                <select name="etudiant_id" id="etudiant" class="w-full border border-gray-300 p-2 rounded">
                    <option value="1">12345 - Jean Dupont</option>
                    <option value="2">67890 - Marie Curie</option>
                    <!-- Ajoutez d'autres options ici -->
                </select>
            </div>
            <div class="mb-4">
                <label for="ec" class="block text-gray-700">Élément Constitutif (EC)</label>
                <select name="ec_id" id="ec" class="w-full border border-gray-300 p-2 rounded">
                    <option value="1">EC101 - Mathématiques</option>
                    <option value="2">EC102 - Physique</option>
                    <!-- Ajoutez d'autres options ici -->
                </select>
            </div>
            <div class="mb-4">
                <label for="note" class="block text-gray-700">Note</label>
                <input type="number" name="note" id="note" min="0" max="20" step="0.25" class="w-full border border-gray-300 p-2 rounded">
            </div>
            <div class="mb-4">
                <label for="session" class="block text-gray-700">Session</label>
                <select name="session" id="session" class="w-full border border-gray-300 p-2 rounded">
                    <option value="normale">Session Normale</option>
                    <option value="rattrapage">Rattrapage</option>
                </select>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Enregistrer</button>
        </form>
    </main>
</body>
</html>
