<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnInvoice1 extends Model
{
    use HasFactory;
    protected $table = "pos_return_invoices1";
    protected  $guarded = ['id'];


    public function invoice(){

        return $this->BelongsTo('App\Models\POS\Invoice1','invoice_id');
    }
    
    public function client(){
    
        return $this->BelongsTo('App\Models\Client1','client_id');
    }
    
    
}
