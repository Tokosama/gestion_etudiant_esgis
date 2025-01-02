<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use App\Models\UE;
use App\Models\EC;
use App\Models\Etudiant;


class NoteController extends Controller
{
    // NoteController.php

    // NoteController.php
public function index()
{
    // Récupérer toutes les notes avec leurs relations (ECs et UEs associées)
    $notes = Note::with('ec.ue')->get();

    // Retourner la vue avec les données des notes
    return view('notes.index', compact('notes'));
}
public function create()
    {
        $ecs = EC::all();  // Récupérer les EC
        $etudiants = Etudiant::all();  // Récupérer les étudiants
        return view('notes.create', compact('ecs', 'etudiants'));
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
    
        // Vérification de la session et mise à jour de la note si nécessaire
        if ($validatedData['session'] === 'rattrapage') {
            // Vérifier s'il existe une note de session normale pour cet étudiant et cet EC
            $noteNormale = Note::where('etudiant_id', $validatedData['etudiant_id'])
                               ->where('ec_id', $validatedData['ec_id'])
                               ->where('session', 'normale')
                               ->first();
    
            if ($noteNormale) {
                // Si une note normale existe, comparer les notes
                if ($validatedData['note'] > $noteNormale->note) {
                    // Si la note de rattrapage est supérieure à la note normale, mettre à jour la note normale
                    $noteNormale->note = $validatedData['note'];  // Remplacer la note normale par la note de rattrapage
                    $noteNormale->date_evaluation = $validatedData['date_evaluation']; // Mettre à jour la date d'évaluation
                    $noteNormale->save();  // Sauvegarder les modifications
    
                   
                }
            } else {
                // Si la note normale n'existe pas, alors créer une note de rattrapage normalement
                Note::create([
                    'ec_id' => $validatedData['ec_id'],
                    'etudiant_id' => $validatedData['etudiant_id'],
                    'note' => $validatedData['note'],
                    'session' => 'rattrapage',
                    'date_evaluation' => $validatedData['date_evaluation'],
                ]);
            }
        } else {
            // Enregistrer une note de session normale si la session est normale
            Note::create([
                'ec_id' => $validatedData['ec_id'],
                'etudiant_id' => $validatedData['etudiant_id'],
                'note' => $validatedData['note'],
                'session' => 'normale',
                'date_evaluation' => $validatedData['date_evaluation'],
            ]);
        }
    
        return redirect()->route('notes.index')->with('success', 'Note enregistrée avec succès');
    }
    
    

    public function calculerMoyenneUE($etudiantId, $ueId)
    {
        $notes = Note::whereHas('ec', function($query) use ($ueId) {
            $query->where('ue_id', $ueId);
        })
        ->where('etudiant_id', $etudiantId)
        ->get();
    
        // Vérifier si une note est manquante
        $notesManquantes = false;
        foreach ($notes as $note) {
            if (is_null($note->note)) {
                $notesManquantes = true;
                break;
            }
        }
    
        if ($notesManquantes) {
            return 'Note manquante pour cet EC';
        }
    
        $sommeNotes = 0;
        $sommeCoefficients = 0;
    
        foreach ($notes as $note) {
            $sommeNotes += $note->note * $note->ec->coefficient;
            $sommeCoefficients += $note->ec->coefficient;
        }
    
        $moyenne = $sommeNotes / $sommeCoefficients;
        return view('notes.moyenne', compact('moyenne'));
    }
    
public function validerUE($etudiantId, $ueId)
{
    $moyenne = $this->calculerMoyenneUE($etudiantId, $ueId);

    if ($moyenne === 'Note manquante pour cet EC') {
        return redirect()->back()->with('error', 'Impossible de valider l\'UE. Une ou plusieurs notes sont manquantes.');
    }
    $notes = Note::whereHas('ec', function($query) use ($ueId) {
        $query->where('ue_id', $ueId);
    })
    ->where('etudiant_id', $etudiantId)
    ->get();

    $sommeNotes = 0;
    $sommeCoefficients = 0;

    foreach ($notes as $note) {
        $sommeNotes += $note->note * $note->ec->coefficient;
        $sommeCoefficients += $note->ec->coefficient;
    }

    $moyenne = $sommeNotes / $sommeCoefficients;

    if ($moyenne >= 10) {
        // L'UE est validée
        $creditsAcquis = UE::find($ueId)->credits_ects;
    } else {
        // L'UE n'est pas validée
        $creditsAcquis = 0;
    }

    return view('notes.validation', compact('moyenne', 'creditsAcquis'));
}

// NoteController.php

public function afficherResultatsGlobauxParSemestre($etudiantId, $semestre)
{
    $etudiant = Etudiant::findOrFail($etudiantId);
    
    $notes = Note::with('ec.ue')
                 ->where('etudiant_id', $etudiantId)
                 ->whereHas('ec.ue', function($query) use ($semestre) {
                     $query->where('semestre', $semestre);
                 })
                 ->get();

    $resultatsParSemestre = [];
    $validationSemestre = [];
    $compensationPossible = false;
    $sommeNotes = 0;
    $sommeCoefficients = 0;

    foreach ($notes as $note) {
        $ueId = $note->ec->ue_id;
        $semestre = $note->ec->ue->semestre;

        if (!isset($resultatsParSemestre[$semestre])) {
            $resultatsParSemestre[$semestre] = [];
        }

        if (!isset($resultatsParSemestre[$semestre][$ueId])) {
            $resultatsParSemestre[$semestre][$ueId] = [
                'ue' => $note->ec->ue,
                'somme_notes' => 0,
                'somme_coefficients' => 0,
                'credits_ects' => $note->ec->ue->credits_ects,
                'moyenne' => 0,
                'valide' => false
            ];
        }

        // Calculer la somme des notes et des coefficients
        $resultatsParSemestre[$semestre][$ueId]['somme_notes'] += $note->note * $note->ec->coefficient;
        $resultatsParSemestre[$semestre][$ueId]['somme_coefficients'] += $note->ec->coefficient;
        $sommeNotes += $note->note * $note->ec->coefficient;
        $sommeCoefficients += $note->ec->coefficient;
    }

    // Calcul des moyennes et validation des UEs par semestre
    foreach ($resultatsParSemestre as $semestre => &$ues) {
        $creditsValides = 0;
        $creditsTotal = 0;
        $compensationPossible = false; // Reset compensation flag

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
            'valide' => ($creditsValides >= $creditsTotal) || $compensationPossible
        ];
    }

    return view('notes.resultats_semestre', compact('resultatsParSemestre', 'validationSemestre', 'etudiant'));
}
// Affichage des résultats globaux de l'étudiant (sans semestres spécifiques)
public function afficherResultatsGlobaux($etudiantId)
{
    // Récupérer l'étudiant
    $etudiant = Etudiant::findOrFail($etudiantId);

    // Récupérer les notes de l'étudiant avec les ECs et UEs associés
    $notes = Note::with('ec.ue')
                 ->where('etudiant_id', $etudiantId)
                 ->get();

    // Calcul des moyennes et des crédits ECTS
    $resultats = [];
    $creditsAcquis = 0;

    foreach ($notes as $note) {
        $ueId = $note->ec->ue_id;
        $coefficient = $note->ec->coefficient;

        if (!isset($resultats[$ueId])) {
            $resultats[$ueId] = [
                'ue' => $note->ec->ue,
                'somme_notes' => 0,
                'somme_coefficients' => 0,
                'credits_ects' => $note->ec->ue->credits_ects,
                'notes' => []
            ];
        }

        // Calcul des notes et des coefficients
        $resultats[$ueId]['somme_notes'] += $note->note * $coefficient;
        $resultats[$ueId]['somme_coefficients'] += $coefficient;
        $resultats[$ueId]['notes'][] = $note;
    }

    // Calcul de la moyenne et validation de chaque UE
    foreach ($resultats as $ueId => &$data) {
        $moyenneUE = $data['somme_notes'] / $data['somme_coefficients'];
        $data['moyenne'] = $moyenneUE;
        $data['valide'] = $moyenneUE >= 10;
    }

    // Calcul des crédits ECTS
    foreach ($resultats as $data) {
        if ($data['valide']) {
            $creditsAcquis += $data['credits_ects'];
        }
    }

    return view('notes.resultats', compact('resultats', 'creditsAcquis', 'etudiant'));
}

// App\Http\Controllers\NoteController.php
public function afficherResultatsParAnneeEtudiant($etudiantId)
{
    $etudiant = Etudiant::findOrFail($etudiantId);

    $anneeEtude = $etudiant->annee_etude;
    $semestresAAfficher = [];

    if ($anneeEtude == 'L1') {
        $semestresAAfficher = [1, 2];
    } elseif ($anneeEtude == 'L2') {
        $semestresAAfficher = [3, 4];
    } elseif ($anneeEtude == 'L3') {
        $semestresAAfficher = [5, 6];
    }

    $resultatsParSemestre = [];
    $creditsTotaux = 0;
    $creditsAcquis = 0;

    foreach ($semestresAAfficher as $semestre) {
        $resultatsParSemestre[$semestre] = $this->obtenirResultatsPourSemestre($etudiantId, $semestre);

        foreach ($resultatsParSemestre[$semestre] as $data) {
            $creditsTotaux += $data['credits_ects'];
            if ($data['valide']) {
                $creditsAcquis += $data['credits_ects'];
            }
        }
    }

    $passeDansAnneeSuivante = $this->verifierPassageAnneeSuivante($etudiantId, $anneeEtude);

    return view('notes.resultats_par_annee', compact('resultatsParSemestre', 'etudiant', 'passeDansAnneeSuivante', 'creditsAcquis', 'creditsTotaux'));
}

public function obtenirResultatsPourSemestre($etudiantId, $semestre)
{
    // Récupérer les notes de l'étudiant pour un semestre donné
    $notes = Note::with('ec.ue')
                 ->where('etudiant_id', $etudiantId)
                 ->whereHas('ec.ue', function ($query) use ($semestre) {
                     $query->where('semestre', $semestre);
                 })
                 ->get();

    $resultats = [];
    foreach ($notes as $note) {
        $ueId = $note->ec->ue_id;
        if (!isset($resultats[$ueId])) {
            $resultats[$ueId] = [
                'ue' => $note->ec->ue,
                'somme_notes' => 0,
                'somme_coefficients' => 0,
                'credits_ects' => $note->ec->ue->credits_ects,
                'notes' => []
            ];
        }

        $resultats[$ueId]['somme_notes'] += $note->note * $note->ec->coefficient;
        $resultats[$ueId]['somme_coefficients'] += $note->ec->coefficient;
        $resultats[$ueId]['notes'][] = $note;
    }

    foreach ($resultats as $ueId => &$data) {
        $moyenneUE = $data['somme_notes'] / $data['somme_coefficients'];
        $data['moyenne'] = $moyenneUE;
        $data['valide'] = $moyenneUE >= 10;
    }

    return $resultats;
}

public function verifierPassageAnneeSuivante($etudiantId, $anneeEtude)
{
    $creditsAcquis = 0;

    // Récupérer les résultats de l'étudiant
    $notes = Note::where('etudiant_id', $etudiantId)->get();

    foreach ($notes as $note) {
        if ($note->note >= 10) { // Validation des UEs avec moyenne >= 10
            $creditsAcquis += $note->ec->ue->credits_ects;
        }
    }

    // Vérifier les conditions de passage
    if ($anneeEtude == 'L1') {
        if ($creditsAcquis >= 60 && $creditsAcquis >= 55) {
            return true; // Passage en L2
        }
    } elseif ($anneeEtude == 'L2') {
        if ($creditsAcquis >= 120 && $creditsAcquis >= 115) {
            return true; // Passage en L3
        }
    }

    return false; // Pas de passage
}

}

