<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Items1 extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = "tbl_items1";
}
