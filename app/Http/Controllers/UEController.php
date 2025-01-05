<?php

namespace App\Http\Controllers;

use App\Models\UE;
use Illuminate\Http\Request;

class UEController extends Controller
{
    public function index()
    {
        $ues = UE::with('ecs')->get();
        return view('ues.index', compact('ues'));
    }

    public function create()
    {
        return view('ues.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:ues|max:10|regex:/^UE\d{2}$/',  // Vérifie que le code suit le format "UExx"
            'nom' => 'required|max:255',
            'credits_ects' => 'required|integer|between:1,30',
            'semestre' => 'required|integer|between:1,6',
        ], [
            'code.regex' => 'Le code de l\'UE doit être au format "UExx", où "xx" est un nombre à deux chiffres.',
            'credits_ects.between' => 'Les crédits ECTS doivent être compris entre 1 et 30.',
            'semestre.between' => 'Le semestre doit être compris entre 1 et 6.',
        ]);
    
        UE::create($request->all());
    
        return redirect()->route('ues.index')->with('success', 'UE créée avec succès.');
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|max:10|unique:ues,code,' . $id . '|regex:/^UE\d{2}$/',  // Vérifie que le code suit le format "UExx"
            'nom' => 'required|max:255',
            'credits_ects' => 'required|integer|between:1,30',
            'semestre' => 'required|integer|between:1,6',
        ], [
            'code.regex' => 'Le code de l\'UE doit être au format "UExx", où "xx" est un nombre à deux chiffres.',
            'credits_ects.between' => 'Les crédits ECTS doivent être compris entre 1 et 30.',
            'semestre.between' => 'Le semestre doit être compris entre 1 et 6.',
        ]);
    
        // Mettre à jour l'UE avec les nouvelles données validées
        $ue = UE::findOrFail($id);
        $ue->update($request->all());
    
        return redirect()->route('ues.index')->with('success', 'UE mise à jour avec succès.');
    }
    
    public function edit($id)
    {
        $ue = UE::findOrFail($id);
        return view('ues.edit', compact('ue'));
    }

    public function destroy($id)
    {
        $ue = UE::findOrFail($id);
        $ue->delete();

        return redirect()->route('ues.index')->with('success', 'UE supprimée avec succès.');
    }
}
