<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseItems1 extends Model
{
    use HasFactory;

    protected $table  = "pos_purchase_items1";

    protected $guarded = ['id'];

    public function purchase(){

        return $this->BelongsTo('App\Models\POS\Purchase1','id');
    }
}
