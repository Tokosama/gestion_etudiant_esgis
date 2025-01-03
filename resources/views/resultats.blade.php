<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats des Étudiants</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <header class="bg-green-500 text-white p-4">
        <h1 class="text-center text-2xl font-bold">Résultats des Étudiants</h1>
        <nav class="flex justify-center space-x-4 mt-2">
        <a href="index" class="hover:underline">Accueil</a>
            <a href="ue" class="hover:underline">Gestion des UEs</a>
            <a href="notes" class="hover:underline">Gestion des Notes</a>
        </nav>
    </header>
    <main class="p-8">
        <h2 class="text-center text-xl font-semibold mb-4">Affichage des Résultats</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead class="bg-green-500 text-white">
                    <tr>
                        <th class="py-2 px-4 border">Numéro Étudiant</th>
                        <th class="py-2 px-4 border">Nom</th>
                        <th class="py-2 px-4 border">Prénom</th>
                        <th class="py-2 px-4 border">UE</th>
                        <th class="py-2 px-4 border">Note</th>
                        <th class="py-2 px-4 border">Session</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="py-2 px-4 border">123</td>
                        <td class="py-2 px-4 border">Majengo</td>
                        <td class="py-2 px-4 border">Gutenberg</td>
                        <td class="py-2 px-4 border">UE11</td>
                        <td class="py-2 px-4 border">14.5</td>
                        <td class="py-2 px-4 border">Normale</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
