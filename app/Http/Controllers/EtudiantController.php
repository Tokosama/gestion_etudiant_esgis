<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use Illuminate\Http\Request;

class EtudiantController extends Controller
{
    public function index()
{
    $etudiants = Etudiant::paginate(10); // 10 étudiants par page
    return view('etudiants.index', compact('etudiants'));
}
 
public function show(Request $request, $id)
{
    // Récupérer l'étudiant avec l'ID donné
    $etudiant = Etudiant::findOrFail($id);
    
    // Récupérer le semestre depuis la requête (par défaut, semestre 1)
    $semestre = $request->input('semestre', 1);
    
    // Récupérer les étudiants ayant des notes dans des ECs liés à des UEs du semestre sélectionné
    $etudiants = Etudiant::whereIn('id', function ($query) use ($semestre) {
        $query->select('etudiant_id')
              ->from('notes')
              ->join('ecs', 'notes.ec_id', '=', 'ecs.id')
              ->join('ues', 'ecs.ue_id', '=', 'ues.id')
              ->where('ues.semestre', $semestre);
    })->get();
    
    // Passer l'étudiant et le semestre à la vue
    return view('etudiants.show', compact('etudiants', 'etudiant', 'semestre'));
}
       
    public function create()
    {
        return view('etudiants.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'numero_etudiant' => 'required|unique:etudiants|max:15',
            'nom' => 'required|max:255',
            'prenom' => 'required|max:255',
            'niveau' => 'required|in:L1,L2,L3',
        ]);

        Etudiant::create($request->all());

        return redirect()->route('etudiants.index')->with('success', 'Étudiant ajouté avec succès.');
    }

    public function edit($id)
    {
        $etudiant = Etudiant::findOrFail($id);
        return view('etudiants.edit', compact('etudiant'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'numero_etudiant' => 'required|max:15|unique:etudiants,numero_etudiant,' . $id,
            'nom' => 'required|max:255',
            'prenom' => 'required|max:255',
            'niveau' => 'required|in:L1,L2,L3',
        ]);

        $etudiant = Etudiant::findOrFail($id);
        $etudiant->update($request->all());

        return redirect()->route('etudiants.index')->with('success', 'Étudiant mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $etudiant = Etudiant::findOrFail($id);
        $etudiant->delete();

        return redirect()->route('etudiants.index')->with('success', 'Étudiant supprimé avec succès.');
    }
}
