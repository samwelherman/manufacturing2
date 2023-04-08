<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Screp extends Model
{
    use HasFactory;
     protected $guarded = ['id'];

  

     public function manager()
     {
       return $this->belongsTo('App\Models\User', 'added_by');
     }


     public function responsible()
     {
       return $this->belongsTo('App\Models\User', 'resposible_person');
     }


    
}
