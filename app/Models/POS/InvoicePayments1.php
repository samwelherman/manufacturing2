<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoicePayments1 extends Model
{
    use HasFactory;

    
    protected $table = "pos_invoice_payments1";

    //protected $quarded = ['id','_token'];
    protected $guarded = ['id'];
}

