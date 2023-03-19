<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceHistory1 extends Model
{
    use HasFactory;
    protected $table = "pos_invoices_history1";
    protected  $guarded = ['id','_token'];


    public function invoice(){

        return $this->hasMany('App\Models\POS\Invoice1','invoice_id');
    }
    
    public function client(){
    
        return $this->BelongsTo('App\Models\Client1','client_id');
    }
}
