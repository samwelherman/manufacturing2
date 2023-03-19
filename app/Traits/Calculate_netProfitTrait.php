<?php
namespace App\Traits;

use App\Models\ClassAccount;
use \App\Models\JournalEntry;

trait Calculate_netProfitTrait {
    
public function get_netProfit($start_date=null,$end_date=null){
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
     
     
                            
                        $cr1 = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr1 = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                            
                 
                          
                        $income_balance1=$dr1- $cr1;
                          $total_incomes1+=$income_balance1 ;      


    }}}}           

foreach($income->where('added_by',auth()->user()->added_by) as $account_class){
foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)  as $group) {  
if($group->group_id == 5110){
foreach($group->accountCodes->where('added_by',auth()->user()->added_by) as $account_code){

                            
                            
                        $cr1 = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr1 = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                   
                        $income_balance1=$dr1- $cr1;
                          $total_other_incomes1+=$income_balance1 ;
   

}}}} 



foreach($cost->where('added_by',auth()->user()->added_by) as $account_class){
foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)  as $group) {
if($group->group_id == 6180){
foreach($group->accountCodes->where('added_by',auth()->user()->added_by) as $account_code){



                            
                        $cr1 = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr1 = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                            
                   
                            
                            
                            
                        $cost_balance1=$dr1- $cr1;
                        
                        $total_cost1+=$cost_balance1 ;
                            

}}}}


foreach($expense->where('added_by',auth()->user()->added_by) as $account_class){
foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)  as $group)  {      
if($group->group_id != 6180){
foreach($group->accountCodes->where('added_by',auth()->user()->added_by) as $account_code){


                            
                        $cr1 = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr1 = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                            
                    
                            
                            

                          
                $expense_balance1=$dr1- $cr1;
                $total_expense1+=$expense_balance1 ;


}}}}



  

if($total_other_incomes1 < 0){
$total_o1=$total_other_incomes1 * -1;
}
else if($total_other_incomes1 >= 0){
$total_o1=$total_other_incomes1 ;
}




if($total_incomes1 < 0){
$total_s1=$total_incomes1 * -1;
$gross1=$total_s1+$total_o1-$total_cost1;
}
else if($total_incomes1 >= 0){
$gross1=$total_incomes1+$total_o1-$total_cost1;
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
   
  

if($profit1 > 0){
$tax1=$profit1*0.3;
}

 
 $data['profit_for_second_date'] =  $profit1-$tax1;
 

 
 $data['tax_for_second_date'] =  $tax1;

   
   
   
   
   return $data; 
   
   
   
   
   
   
   
   
   
   
    }
    
    
    
}