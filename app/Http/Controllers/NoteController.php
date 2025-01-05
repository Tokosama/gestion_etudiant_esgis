<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use App\Models\UE;
use App\Models\EC;
use App\Models\Etudiant;


class NoteController extends Controller
{
 
public function index()
{
    // Récupérer toutes les notes avec leurs relations (ECs et UEs associées)
    $notes = Note::with('ec.ue')->get();

    // Retourner la vue avec les données des notes
    return view('notes.index', compact('notes'));
}
public function create(Request $request)
{
    $etudiants = Etudiant::all(); 
    $ecs = collect(); 

    if ($request->has('etudiant_id')) {
        $etudiantId = $request->input('etudiant_id');
        $etudiant = Etudiant::find($etudiantId);

        if ($etudiant) {
            // Récupération des semestres pour l'année de l'étudiant
            $semestres = $this->getSemestresForAnnee($etudiant->niveau);
            
            // Récupérer les ECs en fonction des semestres des UEs
            $ecs = EC::join('ues', 'ecs.ue_id', '=', 'ues.id')
    ->whereIn('ues.semestre', $semestres)
    ->select('ecs.*') // On sélectionne uniquement les ECs
    ->get();
            
        }
        
    }

    return view('notes.create', compact('etudiants', 'ecs'));
}

// déterminer les semestres selon l'année
private function getSemestresForAnnee($niveau)
{
    return match ($niveau) {
        'L1' => [1, 2],
        'L2' => [3, 4],
        'L3' => [5, 6],
        default => []
    };
}



    public function store(Request $request)
{
    $validatedData = $request->validate([
        'ec_id' => 'required|exists:ecs,id',
        'etudiant_id' => 'required|exists:etudiants,id',
        'note' => 'required|numeric|min:0|max:20',
        'session' => 'required|in:normale,rattrapage',
        'date_evaluation' => 'required|date',
    ]);

    // Vérification si une note existe déjà pour l'étudiant et la session
    $existingNote = Note::where('etudiant_id', $validatedData['etudiant_id'])
                        ->where('ec_id', $validatedData['ec_id'])
                        ->where('session', $validatedData['session'])
                        ->first();

    if ($existingNote) {
        // Si une note existe déjà,on  affiche un message d'erreur
        return redirect()->route('notes.index')->with('error', 'Une note a déjà été enregistrée pour cette session.');
    }

    // Vérification de la session et mise à jour de la note si nécessaire
    if ($validatedData['session'] === 'rattrapage') {
        // Vérifier s'il existe une note de session normale pour cet étudiant et cet EC
        $noteNormale = Note::where('etudiant_id', $validatedData['etudiant_id'])
                           ->where('ec_id', $validatedData['ec_id'])
                           ->where('session', 'normale')
                           ->first();
    
        // Si une note normale existe, aucune mise à jour de cette note n'est effectuée, mais on enregistre une note de rattrapage séparée
        // Si aucune note normale n'existe, une nouvelle note de rattrapage est ajoutée
        Note::create([
            'ec_id' => $validatedData['ec_id'],
            'etudiant_id' => $validatedData['etudiant_id'],
            'note' => $validatedData['note'],
            'session' => 'rattrapage',
            'date_evaluation' => $validatedData['date_evaluation'],
        ]);
    
        return redirect()->route('notes.index')->with('success', 'Note de rattrapage ajoutée avec succès.');
    } else {
        // Enregistrer une note de session normale si la session est normale
        Note::create([
            'ec_id' => $validatedData['ec_id'],
            'etudiant_id' => $validatedData['etudiant_id'],
            'note' => $validatedData['note'],
            'session' => 'normale',
            'date_evaluation' => $validatedData['date_evaluation'],
        ]);
    
        return redirect()->route('notes.index')->with('success', 'Note de session normale ajoutée avec succès.');
    }
    
}

//MIS  A JOUR ET SUPRESSSIONNN 

public function edit($id)
{
    $note = Note::findOrFail($id);
    $etudiants = Etudiant::all();
    $ecs = EC::all();

    return view('notes.edit', compact('note', 'etudiants', 'ecs'));
}

public function update(Request $request, $id)
{
    $validatedData = $request->validate([
        'ec_id' => 'required|exists:ecs,id',
        'etudiant_id' => 'required|exists:etudiants,id',
        'note' => 'required|numeric|min:0|max:20',
        'session' => 'required|in:normale,rattrapage',
        'date_evaluation' => 'required|date',
    ]);

    $note = Note::findOrFail($id);
    $note->update($validatedData);

    return redirect()->route('notes.index')->with('success', 'Note mise à jour avec succès.');
}

public function destroy($id)
{
    $note = Note::findOrFail($id);
    $note->delete();

    return redirect()->route('notes.index')->with('success', 'Note supprimée avec succès.');
}




// RESULTATTTS

public function afficherResultatsGlobauxParSemestre($etudiantId, $semestre)
{
    $etudiant = Etudiant::findOrFail($etudiantId);

    // Récupérer toutes les notes de l'étudiant pour le semestre spécifié
    $notes = Note::with('ec.ue')  // Charger les EC et les UEs associés
                 ->where('etudiant_id', $etudiantId)
                 ->whereHas('ec.ue', function($query) use ($semestre) {
                     $query->where('semestre', $semestre);  // Filtrer les notes pour le semestre
                 })
                 ->get();

    // Tableau pour stocker les notes filtrées (par EC)
    $notesFiltrees = [];

    // Filtrer les notes pour ne conserver que la meilleure note par EC
    foreach ($notes as $note) {
        $ecId = $note->ec_id;

        // Si l'EC n'existe pas encore dans le tableau filtré, on l'ajoute
        if (!isset($notesFiltrees[$ecId])) {
            $notesFiltrees[$ecId] = [
                'ec_id' => $note->ec_id,
                'note' => $note->note,
                'session' => $note->session,
                'ec' => $note->ec,  // EC lié à la note
                'credits_ects' => $note->ec->ue->credits_ects,
                'coefficient' => $note->ec->coefficient
            ];
        } else {
            // Comparaison entre les notes de sessions normales et de rattrapage
            $noteActuelle = $notesFiltrees[$ecId];

            if ($note->note > $noteActuelle['note']) {
                // Si la nouvelle note est meilleure, on la remplace
                $notesFiltrees[$ecId]['note'] = $note->note;
                $notesFiltrees[$ecId]['session'] = $note->session;
            }
        }
    }

    // Calcul des résultats par semestre en utilisant les notes filtrées
    $resultatsParSemestre = [];
    $validationSemestre = [];
    $compensationPossible = false;
    $sommeNotes = 0;
    $sommeCoefficients = 0;

    // Parcours des notes filtrées pour calculer les moyennes
    foreach ($notesFiltrees as $note) {
        $ueId = $note['ec']->ue_id;
        $semestre = $note['ec']->ue->semestre;

        if (!isset($resultatsParSemestre[$semestre])) {
            $resultatsParSemestre[$semestre] = [];
        }

        if (!isset($resultatsParSemestre[$semestre][$ueId])) {
            $resultatsParSemestre[$semestre][$ueId] = [
                'ue' => $note['ec']->ue,
                'somme_notes' => 0,
                'somme_coefficients' => 0,
                'credits_ects' => $note['ec']->ue->credits_ects,
                'moyenne' => 0,
                'valide' => false
            ];
        }

        // Calculer la somme des notes et des coefficients
        $resultatsParSemestre[$semestre][$ueId]['somme_notes'] += $note['note'] * $note['ec']->coefficient;
        $resultatsParSemestre[$semestre][$ueId]['somme_coefficients'] += $note['ec']->coefficient;
        $sommeNotes += $note['note'] * $note['ec']->coefficient;
        $sommeCoefficients += $note['ec']->coefficient;
    }

    // Calcul des moyennes et validation des UEs par semestre
    foreach ($resultatsParSemestre as $semestre => &$ues) {
        $creditsValides = 0;
        $creditsTotal = 0;
        $compensationPossible = false;

        foreach ($ues as &$data) {
            $data['moyenne'] = $data['somme_notes'] / $data['somme_coefficients'];
            $data['valide'] = $data['moyenne'] >= 10;

            // Vérification de la compensation
            if (!$data['valide'] && $data['moyenne'] >= 8) {
                $compensationPossible = true;
            }

            if ($data['valide']) {
                $creditsValides += $data['credits_ects'];
            }

            $creditsTotal += $data['credits_ects'];
        }

        // Vérification si le semestre est validé avec compensation
        $validationSemestre[$semestre] = [
            'credits_valides' => $creditsValides,
            'credits_totaux' => $creditsTotal,
            'valide' => ($creditsValides === $creditsTotal)
        ];
    }

    return view('notes.resultats_semestre', compact('resultatsParSemestre', 'validationSemestre', 'etudiant'));
}


public function obtenirResultatsPourSemestre($etudiantId, $semestre)
    {
    $ues = UE::where('semestre', $semestre)->get();

    // Récupérer les notes de l'étudiant pour ce semestre
    $notes = Note::with('ec.ue')
                 ->where('etudiant_id', $etudiantId)
                 ->whereHas('ec.ue', function ($query) use ($semestre) {
                     $query->where('semestre', $semestre);
                 })
                 ->get();

    $notesFiltrees = [];

    // Filtrer les notes pour ne conserver que la meilleure par EC
    foreach ($notes as $note) {
        $ecId = $note->ec_id;

        if (!isset($notesFiltrees[$ecId])) {
            $notesFiltrees[$ecId] = [
                'ec_id' => $note->ec_id,
                'note' => $note->note,
                'session' => $note->session,
                'ec' => $note->ec,
                'credits_ects' => $note->ec->ue->credits_ects,
                'coefficient' => $note->ec->coefficient
            ];
        } else {
            $noteActuelle = $notesFiltrees[$ecId];
            if ($note->note > $noteActuelle['note']) {
                $notesFiltrees[$ecId]['note'] = $note->note;
                $notesFiltrees[$ecId]['session'] = $note->session;
            }
        }
    }

    $resultats = [];
    foreach ($ues as $ue) {
        $resultats[$ue->id] = [
            'ue' => $ue,
            'somme_notes' => 0,
            'somme_coefficients' => 0,
            'credits_ects' => $ue->credits_ects,
            'moyenne' => 0,
            'valide' => false,
            'notes' => []
        ];
    }

    foreach ($notesFiltrees as $note) {
        $ueId = $note['ec']->ue_id;

        if (isset($resultats[$ueId])) {
            $resultats[$ueId]['somme_notes'] += $note['note'] * $note['ec']->coefficient;
            $resultats[$ueId]['somme_coefficients'] += $note['ec']->coefficient;
            $resultats[$ueId]['notes'][] = $note;
        }
    }

    foreach ($resultats as $ueId => &$data) {
        if ($data['somme_coefficients'] > 0) {
            $data['moyenne'] = $data['somme_notes'] / $data['somme_coefficients'];
            $data['valide'] = $data['moyenne'] >= 10;
        }
    }

    return $resultats;
}

public function afficherResultatsParAnneeEtudiant($etudiantId)
{
    $etudiant = Etudiant::findOrFail($etudiantId);

    $anneeEtude = $etudiant->niveau;
    $semestresAAfficher = [];

    if ($anneeEtude == 'L1') {
        $semestresAAfficher = [1, 2];
    } elseif ($anneeEtude == 'L2') {
        $semestresAAfficher = [3, 4];
    } elseif ($anneeEtude == 'L3') {
        $semestresAAfficher = [5, 6];
    }

    $resultatsParSemestre = [];
    $creditsTotaux = 0; // Initialisation des crédits totaux
    $creditsAcquis = 0;

    foreach ($semestresAAfficher as $semestre) {
        $resultatsParSemestre[$semestre] = $this->obtenirResultatsPourSemestre($etudiantId, $semestre);

        foreach ($resultatsParSemestre[$semestre] as $data) {
            $creditsTotaux += $data['credits_ects']; // Ajout des crédits ECTS de chaque UE
            if ($data['valide']) {
                $creditsAcquis += $data['credits_ects'];
            }
        }
    }

    $passeDansAnneeSuivante = $creditsAcquis === $creditsTotaux && $creditsTotaux !== 0;

    return view('notes.resultats_par_annee', compact(
        'resultatsParSemestre', 
        'etudiant', 
        'passeDansAnneeSuivante', 
        'creditsAcquis', 
        'creditsTotaux'
    ));
}




}