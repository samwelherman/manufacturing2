<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodMovement extends Model
{
    use HasFactory;

    protected $table = "good_movements";

    protected $fillable = [
         'date',      
       'item_id',
        'staff',   
        'source_location',  
       'destination_location',            
        'quantity', 
      'status',
        'added_by'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }

        
    public function items()
    {
        return $this->belongsTo('App\Models\POS\Items','item_id');
    }

         
    public function source()
    {
        return $this->belongsTo('App\Models\Location','source_location');
    }

    public function destination()
    {
        return $this->belongsTo('App\Models\Location','destination_location');
    }
}
