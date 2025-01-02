<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    protected $fillable = ['numero_etudiant', 'nom', 'prenom', 'niveau'];

    public function notes()
    {
        return $this->hasMany(Note::class, 'etudiant_id');
    }
    public function getAnneeEtudeAttribute()
{
    if ($this->credits_acquis >= 120) {
        return 'L3'; // Si plus de 120 crédits, l'étudiant est en L3
    } elseif ($this->credits_acquis >= 60) {
        return 'L2'; // Si entre 60 et 120 crédits, l'étudiant est en L2
    } else {
        return 'L1'; // Sinon, il est en L1
    }
}
}
