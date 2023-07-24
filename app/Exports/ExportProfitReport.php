<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\AccountCodes;
use App\Models\JournalEntry;

class  ExportProfitReport implements FromView
{
    protected $name,$start,$end;

 public function __construct(String  $name,String $start,String $end){
            $this->name = $name;
           $this->start= $start;
             $this->end= $end;
        }


   public function view() : View
    {
 $codes=AccountCodes::where('account_group','Receivables')->first();

       $purchase=JournalEntry::where('project_id',  $this->name)->where('transaction_type','pos_purchase')->whereBetween('date',[$this->start,$this->end])->where('added_by',auth()->user()->added_by)->sum('credit');         
   $debit = JournalEntry::where('project_id',  $this->name)->where('transaction_type','pos_debit_note')->whereBetween('date',[$this->start,$this->end])->where('added_by',auth()->user()->added_by)->sum('debit');
  $invoice=JournalEntry::where('project_id',  $this->name)->where('transaction_type','pos_invoice')->where('account_id', $codes->id)->whereBetween('date',[$this->start,$this->end])->where('added_by',auth()->user()->added_by)->sum('debit');  
  $credit = JournalEntry::where('project_id',  $this->name)->where('transaction_type','pos_credit_note')->where('account_id', $codes->id)->whereBetween('date',[$this->start,$this->end])->where('added_by',auth()->user()->added_by)->sum('credit');
$expense=JournalEntry::where('project_id',  $this->name)->where('transaction_type','expense_payment')->whereBetween('date',[$this->start,$this->end])->where('added_by',auth()->user()->added_by)->sum('debit'); 


        return view('project.report.profit_report_excel', [
          'purchase' => $purchase,
          'debit' => $debit,
            'invoice' => $invoice,
            'credit' => $credit,
            'expense' => $expense,
            'name' => $this->name,
              'start' => $this->start,
             'end' => $this->end,
        ]);
    }

  
  
}