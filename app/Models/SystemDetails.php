<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemDetails extends Model
{
    use HasFactory;
    protected $table = "system_bank_details";
     protected $guarded = ['id'];
}
