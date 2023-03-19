<?php

namespace App\Models\Manufacturing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store_Items extends Model
{
    use HasFactory;

    protected $table = "tbl_store_items";


    
    public function location()
    {
        return $this->belongsTo('App\Models\Location','location_id');
    }

    public function items()
    {
        return $this->belongsTo('App\Models\POS\Items','items_id');
    }
}
