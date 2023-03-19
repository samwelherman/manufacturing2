<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    protected $table = "tbl_deposit";

    public $timestamps = false;

    protected $fillable = [
        'bank_id',
        'trans_id',
        'amount',
        'date',
        'type',
       'name',
      'ref',
        'status',
        'exchange_rate',
        'exchange_code',
        'payment_method',
        'notes',   
        'account_id', 
        'added_by'];
    
      public function classAccount()
    {
        return $this->hasOne(ClassAccount::class, 'class_name', 'class');
    }
    
     public function journalEntry()
    {
        return $this->hasMany(JournalEntry::class, 'account_id', 'account_id');
    }
public function chart()
    {
        return $this->hasOne(ChartOfAccount::class, 'id', 'account_id');
    }
}