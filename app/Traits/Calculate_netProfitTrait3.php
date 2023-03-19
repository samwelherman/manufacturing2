<?php
namespace App\Traits;

use App\Models\ClassAccount;
use \App\Models\JournalEntry;

trait Calculate_netProfitTrait3 {
    
public function get_netProfit3($start_date=null,$second_date=null,$end_date=null){
$c=0;     
$sales_balance  = 0;
$sales_balance1  = 0;
$total_incomes  = 0;
$total_incomes1 = 0;
$total_other_incomes  = 0;
$total_other_incomes1 = 0;
$cost_balance  = 0;
$cost_balance1  = 0;
$total_cost  = 0;
$total_cost1  = 0;
$expense_balance  = 0;
$expense_balance1 = 0;
$total_expense  = 0;
$total_expense1  = 0;
$gross  = 0;
$gross1  = 0;
$profit=0;
$profit1=0;
$tax=0;
$tax1=0;
$net_profit=0;
$net_profit1=0;   
        
        
        
        //calculate unknown date
        
        //$datediff = strtotime($end_date) - strtotime($second_date);
         
         //$unknown_date  = strtotime($second_date) - $datediff;
         
         //$start_date = date('d - m - Y',$unknown_date);
        
          
        $income = ClassAccount::where('class_type','Income')->where('added_by',auth()->user()->added_by)->get();
           $cost = ClassAccount::where('class_type','Expense')->where('added_by',auth()->user()->added_by)->get();
           $expense= ClassAccount::where('class_type','Expense')->where('added_by',auth()->user()->added_by)->get();
           
           
foreach($income->where('added_by',auth()->user()->added_by) as $account_class){
foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)  as $group) {  
if($group->group_id != 5110){
foreach($group->accountCodes->where('added_by',auth()->user()->added_by) as $account_code){
     
     
                        $cr =JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr = JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                              [$start_date, $second_date])->sum('debit');
                            
                        $cr1 = JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$second_date, $end_date])->sum('credit');
                        $dr1 = JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$second_date, $end_date])->sum('debit');
                            
                            
                 

                       $income_balance=$dr- $cr;
                          $total_incomes+=$income_balance ;
                          
                        $income_balance1=$dr1- $cr1;
                          $total_incomes1+=$income_balance1 ;      


    }}}}           

foreach($income->where('added_by',auth()->user()->added_by) as $account_class){
foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)  as $group) {  
if($group->group_id == 5110){
foreach($group->accountCodes->where('added_by',auth()->user()->added_by) as $account_code){
   
                    $cr =JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                    $dr = JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                              [$start_date, $second_date])->sum('debit');
                            
                    $cr1 = JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$second_date, $end_date])->sum('credit');
                    $dr1 = JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$second_date, $end_date])->sum('debit');
                            
                   
                
                       $income_balance=$dr- $cr;
                        $income_balance1=$dr1- $cr1;
                          $total_other_incomes+=$income_balance ;
                          $total_other_incomes1+=$income_balance1 ;
   

}}}} 



foreach($cost->where('added_by',auth()->user()->added_by) as $account_class){
foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)  as $group) {
if($group->group_id == 6180){
foreach($group->accountCodes->where('added_by',auth()->user()->added_by) as $account_code){


                    $cr =JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                    $dr = JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                              [$start_date, $second_date])->sum('debit');
                            
                    $cr1 = JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$second_date, $end_date])->sum('credit');
                    $dr1 = JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$second_date, $end_date])->sum('debit');
                            
                            
                   
                            
                            
                            
                        $cost_balance=$dr- $cr;
                        $cost_balance1=$dr1- $cr1;
                        
                        $total_cost+=$cost_balance ;
                        $total_cost1+=$cost_balance1 ;
                            

}}}}


foreach($expense->where('added_by',auth()->user()->added_by) as $account_class){
foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)  as $group)  {      
if($group->group_id != 6180){
foreach($group->accountCodes->where('added_by',auth()->user()->added_by) as $account_code){

                    $cr =JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                    $dr = JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                              [$start_date, $second_date])->sum('debit');
                            
                    $cr1 = JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$second_date, $end_date])->sum('credit');
                    $dr1 = JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$second_date, $end_date])->sum('debit');
                            
                            
                    
                            
                            
                            
                $expense_balance=$dr- $cr;
                $total_expense+=$expense_balance ;
                          
                $expense_balance1=$dr1- $cr1;
                $total_expense1+=$expense_balance1 ;


}}}}



  
if($total_other_incomes < 0){
$total_o=$total_other_incomes * -1;
}
else if($total_other_incomes >= 0){
$total_o=$total_other_incomes ;
}

if($total_other_incomes1 < 0){
$total_o1=$total_other_incomes1 * -1;
}
else if($total_other_incomes1 >= 0){
$total_o1=$total_other_incomes1 ;
}


if($total_incomes < 0){
$total_s=$total_incomes * -1;
$gross=$total_s+$total_o-$total_cost;
}
else if($total_incomes >= 0){
$gross=$total_incomes+$total_o-$total_cost;
}

if($total_incomes1 < 0){
$total_s1=$total_incomes1 * -1;
$gross1=$total_s1+$total_o1-$total_cost1;
}
else if($total_incomes1 >= 0){
$gross1=$total_incomes1+$total_o1-$total_cost1;
}
   


if($gross < 0){
$profit=($gross+$total_expense);
}
else if($gross < 0 && $total_expense < 0){
$profit=($gross+$total_expense);
}
else if($gross >= 0 && $total_expense < 0){
$profit=$total_expense +$gross;
}
else{
$profit=$gross-$total_expense;
}

//range for second date
if($gross1 < 0){
$profit1=$gross1+$total_expense1;
}
else if($gross1 < 0 && $total_expense1 < 0){
$profit1=$gross1+$total_expense1;
}
else if($gross1 >= 0 && $total_expense1 < 0){
$profit1=$total_expense1 +$gross1;
}
else{
$profit1=$gross1-$total_expense1;
}  
   
if($profit > 0){
$tax=$profit*0.3;
}
if($profit1 > 0){
$tax1=$profit1*0.3;
}

 //$data['profit_for_first_date'] =   $profit-$tax;
 
 //$data['profit_for_second_date'] =  $profit1-$tax1;
 

 $data['profit_for_first_date'] =   $profit;
 
 $data['profit_for_second_date'] =  $profit1;

 $data['tax_for_first_date'] =   $tax;
 
 $data['tax_for_second_date'] =  $tax1;   
   
   
   
   return $data; 
   
   
   
   
   
   
   
   
   
   
    }
    
    
    
}