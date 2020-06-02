<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RendezVous extends Model
{
    protected $table="rendez_vous";
    protected $fillable=['date','vehicule_id','commentaire'];
}
