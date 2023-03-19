<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice1 extends Model
{
    use HasFactory;
    protected $table = "pos_invoices1";
    protected  $guarded = ['id'];


    public function invoice_items(){

        return $this->hasMany('App\Models\POS\InvoiceItems1','id');
    }
    
    public function client(){
    
        return $this->BelongsTo('App\Models\Client1','client_id');
    }
}
