<?php

namespace App\Models\Manufacturing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainMovement extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function source()
    {
        return $this->belongsTo('App\Models\Location','source_location');
    }

    public function destination()
    {
        return $this->belongsTo('App\Models\Location','destination_location');
    }
}
