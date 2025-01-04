<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UEController;
use App\Http\Controllers\ECController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ListeEtudiantController;
use App\Models\Etudiant;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Route d'accueil par défaut
/*Route::get('/', function () {
    return view('welcome'); // Page d'accueil
})->name('home');*/

Route::get('/', [HomeController::class, 'index'])->name('home');



Route::resource('ues', UEController::class);
    // Gestion des ECs
    Route::resource('ecs', ECController::class);
    // Gestion des étudiants
    Route::resource('etudiants', EtudiantController::class);


// routes/web.php
    // Afficher le formulaire de création
    Route::get('/notes/create', [NoteController::class, 'create'])->name('notes.create');
    Route::get('/notes/{id}/edit', [EtudiantController::class, 'edit'])->name('notes.edit');
    Route::delete('/notes/{id}', [EtudiantController::class, 'destroy'])->name('notes.destroy');


    // Stocker la note
    Route::post('/notes', [NoteController::class, 'store'])->name('notes.store');
    Route::get('/notes', [NoteController::class, 'index'])->name('notes.index');

   //  Route::get('/resultats/{etudiantId}', [NoteController::class, 'afficherResultatsGlobaux'])->name('notes.resultats');
   Route::get('/resultats/etudiant/{etudiantId}/semestre/{semestre}', [NoteController::class, 'afficherResultatsGlobauxParSemestre'])->name('resultats.semestre');

   Route::get('/etudiant/{id}/resultats', [NoteController::class, 'afficherResultatsParAnneeEtudiant'])
    ->name('etudiant.resultats');






