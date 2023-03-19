<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase1 extends Model
{
    use HasFactory;

    protected $table  = "pos_purchases1";

    protected $guarded = ['id'];

public function purchase_items(){

    return $this->hasMany('App\Models\POS\PurchaseItems1','id');
}

public function supplier(){

    return $this->BelongsTo('App\Models\Supplier1','supplier_id');
}
}
