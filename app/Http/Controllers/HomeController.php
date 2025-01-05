<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\UE;
use App\Models\Note;
use App\Models\Ec;



class HomeController extends Controller
{
    public function index()
    {
        $totalUEs = UE::count();
        $totalECs = Ec::count();
        $totalEtudiants = Etudiant::count();
        $totalNotes = Note::count();

        return view('welcome', compact('totalUEs', 'totalECs', 'totalEtudiants', 'totalNotes'));
    }
   
}
