<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Vehicule extends Model
{
    protected $fillable=['immatriculation','marque','model','Pneu','derniereMaintenance'];
}
