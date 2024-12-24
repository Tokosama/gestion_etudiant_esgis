<?php

// app/Http/Controllers/UEController.php

namespace App\Http\Controllers;

use App\Models\UE;
use Illuminate\Http\Request;

class UEController extends Controller
{
    // Afficher la liste des UEs
    public function index()
    {
        $ues = UE::all();
        return view('ues.index', compact('ues'));
    }

    // Afficher le formulaire pour ajouter une UE
    public function create()
    {
        return view('ues.create');
    }

    // Ajouter une nouvelle UE
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'credits_ects' => 'required|integer',
            'semestre' => 'required|integer|min:1|max:6',
        ]);

        UE::create($request->all());

        return redirect()->route('ues.index');
    }

    // Afficher le formulaire pour modifier une UE
    public function edit($id)
    {
        $ue = UE::findOrFail($id);
        return view('ues.edit', compact('ue'));
    }

    // Mettre à jour une UE
    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|string|max:10',
            'nom' => 'required|string|max:50',
            'credits_ects' => 'required|integer',
            'semestre' => 'required|integer|min:1|max:6',
        ]);

        $ue = UE::findOrFail($id);
        $ue->update($request->all());

        return redirect()->route('ues.index');
    }

    // Supprimer une UE
    public function destroy($id)
    {
        $ue = UE::findOrFail($id);
        $ue->delete();

        return redirect()->route('ues.index');
    }
}
