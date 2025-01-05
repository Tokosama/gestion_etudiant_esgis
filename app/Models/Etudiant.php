<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{    use HasFactory;
    protected $fillable = ['numero_etudiant', 'nom', 'prenom', 'niveau'];

    public function notes()
    {
        return $this->hasMany(Note::class, 'etudiant_id');
    }
  
}
