<?php

namespace App\Http\Controllers;

use App\Models\EC;
use App\Models\UE;
use Illuminate\Http\Request;

class ECController extends Controller
{
    public function index()
    {
        $ecs = EC::with('ue')->get();
        return view('ecs.index', compact('ecs'));
    }

    public function create()
    {
        $ues = UE::all();
        return view('ecs.create', compact('ues'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:ecs|max:10|regex:/^EC\d{2}$/',  // Format ECxx
            'nom' => 'required|max:255',
            'coefficient' => 'required|integer|between:1,5',
            'ue_id' => 'required|exists:ues,id',
        ], [
            'code.regex' => 'Le code de l\'EC doit respecter le format ECxx (exemple: EC01).',
        ]);
    
        EC::create($request->all());
    
        return redirect()->route('ecs.index')->with('success', 'EC créé avec succès.');
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|max:10|regex:/^EC\d{2}$/|unique:ecs,code,' . $id,  // Format ECxx
            'nom' => 'required|max:255',
            'coefficient' => 'required|integer|between:1,5',
            'ue_id' => 'required|exists:ues,id',
        ], [
            'code.regex' => 'Le code de l\'EC doit respecter le format ECxx (exemple: EC01).',
        ]);
    
        $ec = EC::findOrFail($id);
        $ec->update($request->all());
    
        return redirect()->route('ecs.index')->with('success', 'EC mis à jour avec succès.');
    }
     public function edit($id)
    {
        $ec = EC::findOrFail($id);
        $ues = UE::all();
        return view('ecs.edit', compact('ec', 'ues'));
    }

    public function destroy($id)
    {
        $ec = EC::findOrFail($id);
        $ec->delete();

        return redirect()->route('ecs.index')->with('success', 'EC supprimé avec succès.');
    }
}
