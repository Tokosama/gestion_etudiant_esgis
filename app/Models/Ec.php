<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class EC extends Model
{
    use HasFactory;

    protected $table = 'ecs';
    protected $fillable = ['code', 'nom', 'coefficient', 'ue_id'];

    public function ue()
    {
        return $this->belongsTo(UE::class, 'ue_id');
    }
    
}

