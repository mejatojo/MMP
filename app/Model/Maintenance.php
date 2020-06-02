<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    protected $fillable=['debut','fin','operations','facture','rdv_id'];
}
