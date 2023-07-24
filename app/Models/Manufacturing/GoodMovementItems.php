<?php

namespace App\Models\Manufacturing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodMovementItems extends Model
{
    use HasFactory;

    protected $table = 'good_movement_items';
    
    protected $guarded = ['id'];
}