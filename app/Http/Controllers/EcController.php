<?php

// app/Http/Controllers/EcController.php

namespace App\Http\Controllers;

use App\Models\Ec;
use App\Models\Ue;
use Illuminate\Http\Request;

class EcController extends Controller
{
    // Afficher tous les Ecs
    public function index()
    {
        $ecs = Ec::all(); 
        return view('ecs.index', compact('ecs')); // Retourner la vue avec les Ecs
    }

    // Afficher le formulaire de création
    public function create()
    {
        $ues = Ue::all(); 
        return view('ecs.create', compact('ues')); // Afficher le formulaire de création avec les UEs
    }

    // Enregistrer un nouvel EC
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'coefficient' => 'required|numeric',
            'ue_id' => 'required|exists:ues,id', // Valider que l'UE existe
        ]);

        Ec::create($validated);

        return redirect()->route('ecs.index')->with('success', 'EC créé avec succès');
    }

    // Afficher le formulaire d'édition
    public function edit(Ec $ec)
    {
        $ues = Ue::all(); 
        return view('ecs.edit', compact('ec', 'ues')); // Afficher le formulaire d'édition avec les données
    }

    // Mettre à jour un EC
    public function update(Request $request, Ec $ec)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:10',
            'nom' => 'required|string|max:50',
            'coefficient' => 'required|numeric',
            'ue_id' => 'required|exists:ues,id', // Valider que l'UE existe
        ]);

        $ec->update($validated); 

        return redirect()->route('ecs.index')->with('success', 'EC mis à jour avec succès');
    }

    // Suppression UE
    public function destroy(Ec $ec)
    {
        $ec->delete(); 

        return redirect()->route('ecs.index')->with('success', 'EC supprimé avec succès');
    }
}
