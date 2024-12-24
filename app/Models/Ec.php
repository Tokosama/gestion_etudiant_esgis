<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ec extends Model
{

    protected $fillable = ['code', 'nom', 'coefficient', 'ue_id'];

    // Relation : Un élément constitutif appartient à une unité d'enseignement (UE)
    public function ue()
    {
        return $this->belongsTo(Ue::class);
    }
}