@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
    <div class="container mx-auto py-16 px-8 bg-gradient-to-b from-gray-50 via-white to-gray-100 min-h-screen">
        <!-- Titre Principal -->
        <h1 class="text-center text-5xl font-extrabold text-gray-800 mb-20 tracking-wide">
            <span class="bg-gradient-to-r from-blue-500 to-indigo-500 text-transparent bg-clip-text">
                Bienvenue sur le Dashboard Étudiant
            </span>
        </h1>
         
           <!-- Section des Statistiques -->
           <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10 mb-16">
            
            <!-- Carte Statistique -->
            <div class="bg-blue-500 shadow-lg rounded-xl p-8 flex items-center justify-between transition-transform transform hover:scale-105">
                <div class="flex items-center">
                    <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-blue-600" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c2.21 0 4-1.79 4-4s-1.79-4-4-4S8 1.79 8 4s1.79 4 4 4zm0 4c-4.42 0-8 1.79-8 4v2c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2v-2c0-2.21-3.58-4-8-4z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-xl font-semibold text-gray-700">Total des UEs</h2>
                        <p class="text-4xl font-extrabold">{{ $totalUEs }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-purple-500 shadow-lg rounded-xl p-8 flex items-center justify-between transition-transform transform hover:scale-105">
                <div class="flex items-center">
                    <div class="w-14 h-14 bg-pink-100 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-pink-600" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2h-5v2zm0 4h5v-2h-5v2zm0-8h5v-2h-5v2zm-4-6H5c-.83 0-1.54.5-1.84 1.22l-3 6A2.003 2.003 0 002 16h8c.83 0 1.54-.5 1.84-1.22l3-6A2.003 2.003 0 0013 6z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-xl font-semibold text-gray-700">Total des ECs</h2>
                        <p class="text-4xl font-extrabold">{{ $totalECs }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-teal-500 shadow-lg rounded-xl p-8 flex items-center justify-between transition-transform transform hover:scale-105">
                <div class="flex items-center">
                    <div class="w-14 h-14 bg-teal-100 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-teal-600" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16v4h-2v-4H7v4H5v-4H3v-4l5.5-4L13 12h1.5c1.1 0 2 .9 2 2v2z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-xl font-semibold text-gray-700">Total des Étudiants</h2>
                        <p class="text-4xl font-extrabold ">{{ $totalEtudiants }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-yellow-500 shadow-lg rounded-xl p-8 flex items-center justify-between transition-transform transform hover:scale-105">
                <div class="flex items-center">
                    <div class="w-14 h-14 bg-yellow-100 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20h4V16h-4v4zM8 4v12H6V4h2zm8 0v12h-2V4h2zm0 16H8v-4H6v4H4V4c0-1.1.9-2 2-2h12c1.1 0 2 .9 2 2v16h-4z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-xl font-semibold text-gray-700">Total des Notes</h2>
                        <p class="text-4xl font-extrabold">{{ $totalNotes }}</p>
                    </div>
                </div>
            </div>
        </div>


        <!-- Section des Actions -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
            <div class="bg-gradient-to-br from-blue-500 to-blue-700 text-white rounded-xl p-8 hover:shadow-2xl transform hover:scale-105 transition">
                <h2 class="text-3xl font-bold mb-4">Unités d'Enseignement</h2>
                <p class="text-blue-100 mb-6">Gérez les UEs, leurs crédits et leurs semestres.</p>
                <a href="{{ route('ues.index') }}" class="bg-white text-blue-700 py-2 px-4 rounded hover:bg-blue-900 hover:text-white transition">
                    Voir les UEs
                </a>
            </div>

            <div class="bg-purple-500 text-white rounded-xl p-8 hover:shadow-2xl transform hover:scale-105 transition">
                <h2 class="text-3xl font-bold mb-4">Éléments Constitutifs</h2>
                <p class="text-pink-100 mb-6">Gérez les ECs et leurs détails.</p>
                <a href="{{ route('ecs.index') }}" class="bg-white text-pink-700 py-2 px-4 rounded hover:bg-indigo-900 hover:text-white transition">
                    Voir les ECs
                </a>
            </div>

            <div class="bg-gradient-to-br from-teal-500 to-teal-700 text-white rounded-xl p-8 hover:shadow-2xl transform hover:scale-105 transition">
                <h2 class="text-3xl font-bold mb-4">Étudiants</h2>
                <p class="text-teal-100 mb-6">Consultez les informations sur les étudiants.</p>
                <a href="{{ route('etudiants.index') }}" class="bg-white text-teal-700 py-2 px-4 rounded hover:bg-teal-900 hover:text-white transition">
                    Voir les Étudiants
                </a>
            </div>

             <!-- Card Notes -->
             <div class="bg-yellow-500 text-white shadow-lg rounded-xl overflow-hidden hover:shadow-2xl transform hover:scale-105 transition">
                <div class="p-8">
                    <h2 class="text-3xl font-bold text-white mb-4">Notes</h2>
                    <p class="text-white/90 mb-6">Saisissez et gérez les notes des étudiants.</p>
                    <a href="{{ route('notes.index') }}" 
                       class="inline-block bg-white text-yellow-500 font-medium py-2 px-4 rounded hover:bg-white transition">
                       Voir les Notes
                    </a>
                </div>
            </div>

                
        </div>
    </div>
@endsection