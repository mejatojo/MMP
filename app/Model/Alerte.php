<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Alerte extends Model
{
        protected $fillable=['vehicule_id','message'];
}
