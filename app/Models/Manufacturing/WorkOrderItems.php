<?php

namespace App\Models\Manufacturing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrderItems extends Model
{
    use HasFactory;

    protected $table = "work_order_items";
    
    protected $guarded = ['id'];


    
    public function work_order()
    {
        return $this->belongsTo('App\Models\Manufacturing\WorkOrder','work_order_id');
    }
    
    // public function user()
    // {
    //     return $this->hasMany('App\Models\User','id', 'responsible_id');
    // }


 public function item(){
        
        return $this->belongsTo('App\Models\POS\Items','product');
    }

 public function assign()
     {
       return $this->belongsTo('App\Models\User', 'responsible_id');
     }

     
 public function client()
 {
   return $this->belongsTo('App\Models\POS\CLient', 'responsible_id');
 }


}
