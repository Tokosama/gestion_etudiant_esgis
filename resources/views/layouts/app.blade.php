<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gestion des Notes ')</title>

    <!-- Inclure les styles via Vite -->
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <header class="my-6">
            <h1 class="text-3xl font-bold text-center">@yield('header', 'Gestion des Notes des etudiants')</h1>
        </header>

        <!-- Contenu principal -->
        <main class="my-8">
            @yield('content')
        </main>
    </div>

    <!-- Inclure les scripts via Vite -->
    @vite('resources/js/app.js')
</body>
</html>
