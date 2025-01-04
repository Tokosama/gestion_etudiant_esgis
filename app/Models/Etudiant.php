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
  
}
