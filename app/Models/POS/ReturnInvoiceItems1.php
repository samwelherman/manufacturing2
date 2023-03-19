<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnInvoiceItems1 extends Model
{
    use HasFactory;

    protected $table = "pos_return_invoice_items1";
    protected  $guarded = ['id'];
}
