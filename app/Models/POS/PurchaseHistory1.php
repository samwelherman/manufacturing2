<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class  PurchaseHistory1 extends Model
{
    use HasFactory;
    protected $table = "pos_purchases_history1";
    protected  $guarded = ['id','_token'];


    public function purchase(){

        return $this->hasMany('App\Models\POS\Purchase1','purchase_id');
    }
    
 
public function supplier(){

    return $this->BelongsTo('App\Models\Supplier1','supplier_id');
}
}
