<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des UEs</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <header class="bg-green-500 text-white p-4">
        <h1 class="text-center text-2xl font-bold">Gestion des UEs</h1>
        <nav class="flex justify-center space-x-4 mt-2">
            <a href="index" class="hover:underline">Accueil</a>
            <a href="notes" class="hover:underline">Gestion des Notes</a>
            <a href="resultats" class="hover:underline">Résultats</a>
        </nav>
    </header>
    <main class="p-8">
        <h2 class="text-center text-xl font-semibold mb-4">Liste des UEs</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead class="bg-green-500 text-white">
                    <tr>
                        <th class="py-2 px-4 border">Code UE</th>
                        <th class="py-2 px-4 border">Nom</th>
                        <th class="py-2 px-4 border">ECs</th>
                        <th class="py-2 px-4 border">ECTS</th>
                        <th class="py-2 px-4 border">Semestre</th>
                        <th class="py-2 px-4 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="py-2 px-4 border">UE11</td>
                        <td class="py-2 px-4 border">Mathématiques</td>
                        <td class="py-2 px-4 border">Analyse : Topologie, continuité, différentiabilité<br>Analyse : Suites, séries intégrales</td>
                        <td class="py-2 px-4 border">6</td>
                        <td class="py-2 px-4 border">S3</td>
                        <td class="py-2 px-4 border">
                            <button class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-700">Modifier</button>
                            <button class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-700">Supprimer</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
