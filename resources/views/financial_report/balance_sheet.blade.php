@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Balance Sheet   </h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Balance Sheet Report
                                    List</a>
                            </li>
                       

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">

<br>
        <div class="panel-heading">
            <h6 class="panel-title">
              Balance Sheet
            @if(!empty($start_date))
                    as at: <b>{{$start_date}}</b>
                   @endif
            </h6>
        </div>

<br>
        <div class="panel-body hidden-print">
            {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form')) !!}
            <div class="row">

                 <div class="col-md-4">
                    <label class="">As at Date</label>
                   <input  name="start_date" type="date" class="form-control date-picker" required value="<?php
                if (!empty($start_date)) {
                    echo $start_date;
                } else {
                     echo date('Y-m-d');
                }
                ?>">
                </div>
              
              

   <div class="col-md-4">
                      <br><button type="submit" class="btn btn-success">Search</button>
                        <a href="{{Request::url()}}"class="btn btn-danger">Reset</a>

                </div>                  
                </div>
           
            {!! Form::close() !!}

        </div>

        <!-- /.panel-body -->

   <br>
  <!-- /.box -->
    @if(!empty($start_date))
<div class="panel panel-white col-lg-12">
            <div class="panel-body table-responsive no-padding">
            
            <button onclick="exportTableToCSV('balance_sheet.csv')"><span>
                                            <i class="icon-folder-download mr-3 icon-2x"></i>Export Table To CSV File
                                        </span></button>

            <table id="data-table" class="table table-striped ">
                     <thead>
                    <tr>
                 <th>#</th>
                        <th colspan="5" style="text-align: center">STATEMENT OF FINANCIAL POSITION FOR THE PERIOD ENDING {{ $start_date }} </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td colspan="5" style="text-align: center"><b>Assets</b></td>
                    </tr>


               <?php
               $c=0;     
                    $total_liabilities = 0;
                    $total_debit_assets = 0;
                    $total_credit_assets = 0;
                      $total_debit_liability  = 0;
                    $total_credit_liability  = 0;
                        $total_debit_equity  = 0;
                    $total_credit_equity  = 0;
                   $total_assets = 0;
                    $total_equity = 0;
                    
                 
?>            
     
     @foreach($asset->where('added_by',auth()->user()->added_by) as $account_class)
<?php    $c++ ; 

 $unit_total1   = 0;
 $unit_total2   = 0;

?>
                          <tr>
                        <td >{{ $c }} . </td>
                        <td ><b>{{ $account_class->class_name  }}</b></td>
                  <td ></td>
                  <?php   if($c == 1){ ?>
                   <?php  } else{ ?>
                     <td ></td>
                    <td ></td>
                    <?php  }  ?>
                    </tr>

  
               
  @foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)  as $group)
                             
@foreach($group->accountCodes->where('added_by',auth()->user()->added_by) as $account_code)
<tr>
 <td></td>
 <td>{{$account_code->account_name }}</td>
​<td><a href="#view{{$account_code->account_id}}" data-toggle="modal"">{{$account_code->account_codes }}</a>
</td>
 <?php
                   
                        $cr1 = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr1 = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');


                         $total_credit_assets +=($dr1-$cr1);
                         
                         $unit_total1  +=($dr1-$cr1);
                        ?>                           
                            <td>{{ number_format($dr1-$cr1,2) }}</td>
                        </tr>
             
                                 
                  
 @endforeach              
  @endforeach
                <tr>
                        <td colspan="3" style="text-align: center">
                            <b>Total {{ $account_class->class_name  }}</b></td>

                        <td><b>{{ number_format($unit_total1,2) }}</b></td>
                  </tr> 

                       </tr> 
                         <tr>
                        <td colspan="5" style="text-align: center">
                            </td>

                    </tr> 
                      

                 
  
  @endforeach
                      
 
           <tr>
                        <td colspan="3" style="text-align: center">
                            <b>Total Assets</b></td>
                        <td><b>{{ number_format($total_credit_assets,2) }}</b></td>

                    </tr>            
                   
     
                       </tr> 
                         <tr>
                        <td colspan="5" style="text-align: center">
                            </td>

                    </tr>
                       </tr> 
                         <tr>
                        <td colspan="5" style="text-align: center">
                            </td>

                    </tr>

                    <tr>
                        <td colspan="5" style="text-align: center "><b>Liabilities</b></td> <!-- sehemu ya liabilitty==================================================== -->
                    </tr>
                     @foreach($liability  as $account_class)
<?php    $c++ ; 

 $unit_total1  =0;
 $unit_total2  =0;

?>
                          <tr>
                        <td >{{ $c }} . </td>
                        <td ><b>{{ $account_class->class_name  }}</b></td>
                  <td colspan="3"></td>
                    </tr>

  
               
  @foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)  as $group)
                             
@foreach($group->accountCodes->where('added_by',auth()->user()->added_by) as $account_code)
@if($account_code->account_name == 'Value Added Tax (VAT)')
<tr>
 <td></td>
 <td>{{$account_code->account_name }}</td>
 <td><a href="#vat{{$account_code->account_id}}" data-toggle="modal"">{{$account_code->account_codes }}</a>

</td>
<?php
                        $cr_in = 0;
                        $dr_in = 0;                   
                        $cr_out  = 0;
                        $dr_out  = 0;
                        $total_vat=0;
                           $total_out=0;
                             $total_in=0;
                             
                      
                        $vat_in= \App\Models\AccountCodes::where('account_name', 'VAT IN')->where('added_by',auth()->user()->added_by)->first();
                        $vat_out= \App\Models\AccountCodes::where('account_name', 'VAT OUT')->where('added_by',auth()->user()->added_by)->first();

                        $cr_in = \App\Models\JournalEntry::where('account_id', $vat_in->account_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_in = \App\Models\JournalEntry::where('account_id', $vat_in->account_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit'); 

                        $cr_out = \App\Models\JournalEntry::where('account_id',  $vat_out->account_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_out = \App\Models\JournalEntry::where('account_id', $vat_out->account_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            

                         $total_in= $dr_in- $cr_in ;
                          $total_out = $cr_out - $dr_out ;
                         if ($total_in - $total_out < 0){
                        $total_vat=($total_in -  $total_out) * -1;
                       }
                       else{
                         $total_vat=($total_in -  $total_out) * -1;;
                         }
                    $unit_total2  =$unit_total2+$total_vat ; ;
                         
  ?>
                          

                                        <td>{{ number_format($total_vat,2) }}  </td>
                                
                          
                        
</tr>

@else
<tr>
 <td></td>
 <td>{{$account_code->account_name }}</td>
​<td><a href="#view{{$account_code->account_id}}" data-toggle="modal"">{{$account_code->account_codes }}</a>
</td>
 <?php
                   
                            
                        $cr1 = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr1 = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');

                      if($account_code->account_name == 'Deffered Tax'){
                       $total_credit_liability  =    $total_credit_liability + $net_profit['tax_for_second_date'];
                                              
                         $unit_total2  +=($cr1-$dr1) +  $net_profit['tax_for_second_date'];

                         }
                         else{
                          
                         $total_credit_liability  +=($cr1-$dr1);                     
                         
                         $unit_total2  +=($cr1-$dr1)  ;
                           }

                       
                        ?>                           
                              @if($account_code->account_name != 'Deffered Tax')
                                                 
                            <td>{{ number_format($cr1-$dr1,2) }}</td>
                         </tr>
                       
                         @else
                             
                            <td>{{ number_format($net_profit['tax_for_second_date'],2) }}</td>
                        </tr>
                         @endif

                    
             
                                 
  @endif                  
 @endforeach              ​
 ​@endforeach
   ​<tr>
                       ​<td colspan="3" style="text-align: right">
                           ​<b>Total {{$account_class->class_name}}</b></td>
                       ​<td><b>{{ number_format($unit_total2 ,2) }}</b></td>

                   ​</tr>    
 ​@endforeach


  ​<tr>
                       ​<td colspan="3" style="text-align: right">
                           ​<b>Total Liabilities</b></td>
                       ​<td><b>{{ number_format($total_credit_liability + $total_vat,2) }}</b></td>

                   ​</tr>     
                       


<tr>
                        <td colspan="5" style="text-align: center"><b>Equities</b></td>   <!-- //sehemu ya equity ==================================================================== -->
                    </tr>
    @foreach($equity   as $account_class)
<?php    $c++ ; 
  
     $unit_cost  = 0;
     $unit_cost1 = 0;

?>
                          <tr>
                        <td >{{ $c }} . </td>
                        <td ><b>{{ $account_class->class_name  }}</b></td>
                  <td colspan="3"></td>
                    </tr>

  
               
  @foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)  as $group)
                             
@foreach($group->accountCodes->where('added_by',auth()->user()->added_by) as $account_code)
<tr>
 <td></td>
 <td>{{$account_code->account_name }}</td>
​<td><a href="#view{{$account_code->account_id}}" data-toggle="modal"">{{$account_code->account_codes }}</a>
</td>
 <?php
                   
                            
                            
                        $cr1 = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr1 = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                     
                     
                         if($account_code->account_codes == 31101){
                         $total_credit_equity    =$total_credit_equity + $net_profit['profit_for_second_date'];
                         $unit_cost1 = $unit_cost1 + $net_profit['profit_for_second_date'];  
                          
                        //   $unit_cost =1000 ;
                        //  $unit_cost1 = 1000;
                         }else{
                         $total_credit_equity    +=($cr1-$dr1) ;
                         $unit_cost1 +=($cr1-$dr1);
                         } ?>
                         @if($account_code->account_codes != 31101)
                                                 
                            <td>{{ number_format($cr1-$dr1,2) }}</td>
                       
                       
                         @else
                             
                            <td>{{ number_format($net_profit['profit_for_second_date'],2) }}</td>
                        </tr>
                         @endif
                                 
                  
 @endforeach              ​
 ​@endforeach
                <tr>
                        <td colspan="3" style="text-align: right">
                            <b>Total {{ $account_class->class_name }}</b></td>
                       ​<td><b>{{ number_format($unit_cost1,2) }}</b></td>
                    </tr>
 ​@endforeach
                   
                                      <tr>
                        <td colspan="3" style="text-align: right">
                            <b>Total Equities</b></td>
                       ​<td><b>{{ number_format($total_credit_equity,2) }}</b></td>
                    </tr>

                    </tbody>
                    <tfoot>
                    
                                                
                    <tr>
                        <td colspan="3" style="text-align: right">
                            <b>Total Liabilities And Equities</b>
                        </td>


                        <td><b>{{ number_format($total_credit_liability+$total_credit_equity + $total_vat,2) }}</b></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    @endif


        

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
 @if(!empty($start_date))
@foreach($asset->where('added_by',auth()->user()->added_by) as $account_class)
  @foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)  as $group)                             
@foreach($group->accountCodes->where('added_by',auth()->user()->added_by) as $account_code) 

                       
  <!-- Modal -->
  <div class="modal fade "id="view{{$account_code->account_id}}"  tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-lg"><div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"  style="text-align:center;"> {{$account_code->account_codes }} - {{$account_code->account_name }}<h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>


        <div class="modal-body">
  <div class="table-responsive">
                            <table class="table datatable-basic table-striped">
<thead>
                    <tr>
                       <th>Date</th>
                            <th>Debit</th>
                        <th>Credit</th>
                      <th>Note</th>
                    </tr>
                    </thead>
 <tbody>
                    <?php                   
                        $account = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->orderBy('date','asc')->get();
                        ?>  
                 @foreach($account  as $a)
                                 <tr>
                        <td >{{$a->date }}</td>
                          <td>{{ number_format($a->debit ,2) }}</td>
                   <td >{{ number_format($a->credit ,2) }}</td>
                      <td >{{ $a->notes }}</td>
                    </tr> 

  @endforeach
    
 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                    
                        ?>  
                    <tr>     
                        <td >
                             <b> Total Balance</b></td>
                           <td><b>{{ number_format($dr,2) }}</b></td>
                            <td><b>{{ number_format($cr,2) }}</b></td>
                          <td></td>
                    </tr> 

                      <tr>     
                        <td >
                             <b>{{$account_code->account_name }} Total Balance</b></td>
                             <td colspan="3"><b>{{ number_format($dr-$cr,2) }}</b></td>
                    </tr> 
 
                              </tbody>
                            </table>
                           </div>

        </div>
       
 <div class="modal-footer ">
         <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>
    </div>
</div></div>
  </div>
 @endforeach
 @endforeach              
  @endforeach

<!-- //sehemu ya equity ==================================================================== -->
 @foreach($equity->where('added_by',auth()->user()->added_by)   as $account_class)
  @foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)  as $group)                             
@foreach($group->accountCodes->where('added_by',auth()->user()->added_by) as $account_code) 

                       
  <!-- Modal -->
  <div class="modal fade "id="view{{$account_code->account_id}}"  tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-lg"><div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"  style="text-align:center;"> {{$account_code->account_codes }} - {{$account_code->account_name }}<h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>


        <div class="modal-body">
  <div class="table-responsive">
                            <table class="table datatable-basic table-striped">
 <?php        
                       if($account_code->account_codes == 31101){
?>
<thead>
                    <tr>
                   <th>Account Name</th>
                        <th>Account Code</th>
                          <th>Balance</th>
         
                    </tr>
                    </thead>
                              <tbody>
 <tr>
                        <td colspan="3" style="text-align: left"><b>Income</b></td>
                    </tr>

  <?php   
$total_incomes_start   = 0;
$total_other_incomes_start   = 0;
$cost_balance_start   = 0;
$total_cost_start   = 0;
$expense_balance_start   = 0;
$total_expense_start   = 0;
$gross_start   = 0;
$profit_start =0;
$tax_start =0;
$net_profit_start =0;
$total_debit_income_balance_start  =0 ;
 $total_credit_income_balance_start   =0 ;
  $total_debit_other_income_balance_start    =0 ;
  $total_credit_other_income_balance_start   =0 ;
   $total_debit_cost_balance_start    =0 ;
   $total_credit_cost_balance_start   =0 ;
   $total_debit_expense_balance_start    =0 ;
   $total_credit_expense_balance_start   =0 ;
$gross_dr_start   = 0;
$gross_cr_start   = 0;
$tax_dr_start =0;
$tax_cr_start =0;
$profit_dr_start =0;
$profit_cr_start =0;   
$net_profit_dr_start =0;
$net_profit_cr_start =0;   

foreach($income->where('added_by',auth()->user()->added_by) as $account_class_modal){
foreach($account_class_modal->groupAccount->where('added_by',auth()->user()->added_by)  as $group_modal) {  
if($group_modal->group_id != 5110){
foreach($group_modal->accountCodes->where('added_by',auth()->user()->added_by) as $account_code_modal){
     
     
                         $cr_start = \App\Models\JournalEntry::where('account_id', $account_code_modal->account_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_start  = \App\Models\JournalEntry::where('account_id', $account_code_modal->account_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');

                         $total_debit_income_balance_start  +=$dr_start  ;
                         $total_credit_income_balance_start  +=$cr_start ;

                          $income_balance_start =$dr_start - $cr_start ;
                          $total_incomes_start +=$income_balance_start  ;
                          ?>
<tr>
  <td>{{$account_code_modal->account_name }}</td>
<td>{{$account_code_modal->account_codes }}</td>
  <td>{{ number_format(abs($income_balance_start),2) }}</td>
</tr>                
  <?php  

    }}}}           
?>

<tr>
                        <td >
                            <b>Total Income</b></td>
                       <td></td>
                            <td>{{ number_format(abs($total_incomes_start),2) }}</td>                           
                    </tr> 
<!--
 
                        <td colspan="3" style="text-align: left"><b> Financial Cost</b></td>
                    </tr>
  <?php  
foreach($cost->where('added_by',auth()->user()->added_by) as $account_class_modal){
foreach($account_class_modal->groupAccount->where('added_by',auth()->user()->added_by)  as $group_modal) {
if($group->group_id == 6180){
foreach($group_modal->accountCodes->where('added_by',auth()->user()->added_by) as $account_code_modal){


                   $cr_start  = \App\Models\JournalEntry::where('account_id', $account_code_modal->account_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_start  = \App\Models\JournalEntry::where('account_id', $account_code_modal->account_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                        $total_debit_cost_balance_start    +=$dr_start  ;
                         $total_credit_cost_balance_start   +=$cr_start ;

                        $cost_balance_start =$dr_start - $cr_start ;
                        $total_cost_start +=$cost_balance_start  ;

  ?>
<tr>
  <td>{{$account_code_modal->account_name }}</td>
<td>{{$account_code_modal->account_codes }}</td>
  <td>{{ number_format(abs($cost_balance_start),2) }}</td>
</tr>                
  <?php  

                            
}}}}
?>

<tr>
                        <td >
                             <b>Total Financial Cost</b></td>
                       <td></td>
      <td>{{ number_format(abs($total_cost_start),2) }}</td>
                    </tr> 
-->

  <?php  

if($total_other_incomes_start < 0){
$total_o_start=$total_other_incomes_start * -1;
}
else if($total_other_incomes_start >= 0){
$total_o_start=$total_other_incomes_start ;
}


if($total_incomes_start < 0){
$total_s_start=$total_incomes_start * -1;
$gross_start=$total_s_start+$total_o_start-$total_cost_start;
}
else if($total_incomes_start >= 0){
$gross_start=$total_incomes_start+$total_o_start-$total_cost_start;
}



?>
<!--
  <tr>
                        <td >
                            <b>Gross Profit</b></td>
                    <td></td>
                            <td><b>{{ number_format($gross_start ,2) }}</b></td>
                    </tr> 
-->

<tr>
                        <td colspan="3" style="text-align: left"><b>Expenses</b></td>
                    </tr>
  <?php  
foreach($expense->where('added_by',auth()->user()->added_by) as $account_class_modal){
foreach($account_class_modal->groupAccount->where('added_by',auth()->user()->added_by)  as $group_modal)  {      
if($group->group_id != 6180){
foreach($group_modal->accountCodes->where('added_by',auth()->user()->added_by) as $account_code_modal){

                   $cr_start  = \App\Models\JournalEntry::where('account_id', $account_code_modal->account_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_start  = \App\Models\JournalEntry::where('account_id', $account_code_modal->account_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                           $total_debit_expense_balance_start    +=$dr_start  ;
                         $total_credit_expense_balance_start   +=$cr_start ;

                $expense_balance_start =$dr_start - $cr_start ;
                $total_expense_start +=$expense_balance_start  ;
                          
  ?>
  <tr>
  <td>{{$account_code_modal->account_name }}</td>
<td>{{$account_code_modal->account_codes }}</td>
  <td>{{ number_format(abs($expense_balance_start ),2) }}</td>
       </tr>             
  <?php  

}}}}

?>

<tr>
                        <td >
                             <b>Total Expenses</b></td>
                       <td></td>
                               <td>{{ number_format($total_expense_start ,2) }}</td>
                    </tr> 

  <?php  

if($gross_start  < 0){
$profit_start =$gross_start + $total_expense_start ;
}
else if($gross_start  < 0 &&  $total_expense_start   < 0){
$profit_start =$gross_start + $total_expense_start ;
}
else if($gross_start  >= 0 &&  $total_expense_start   < 0){
$profit_start = $total_expense_start  +$gross_start ;
}
else{
$profit_start =$gross_start -$total_expense_start ;
}


if($profit_start > 0){
$tax_start =$profit_start *0.3;
}

?>

<tr>
                        <td>
                           <b>Profit Before Tax</b></td>
                            <td></td>
                                 <td><b>{{ number_format($profit_start ,2) }}</b></td>
                    </tr>
                     <tr>
                        <td>
                            <b>Tax</b></td>
                         <td></td>
                              <td><b>{{ number_format($tax_start ,2) }}</b></td>
                    </tr>
                   
<tr>
                      <td colspan=2>
                           <b>{{$account_code->account_name }} Total Balance</b></td>
                        <td colspan=2><b>{{ number_format($profit_start-$tax_start,2) }}</b></td>
                    </tr>


  <?php  
}

else{   
  ?>
<thead>
                    <tr class="">
                       <th>Date</th>
                          <th>Debit</th>
                        <th>Credit</th>
                     <th>Note</th>
                    </tr>
                    </thead>
                              <tbody>   
 <?php
                        $account = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->orderBy('date','asc')->get();
                        ?>  
                 @foreach($account->where('added_by',auth()->user()->added_by)  as $a)
                                 <tr>
                        <td >{{$a->date }}</td>
                          <td>{{ number_format($a->debit ,2) }}</td>
                   <td >{{ number_format($a->credit ,2) }}</td>
                <td >{{ $a->notes }}</td>
                    </tr> 

  @endforeach
    
 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');

                        ?>  
                      <tr>     
                        <td >
                             <b> Total Balance</b></td>
                           <td><b>{{ number_format($dr,2) }}</b></td>
                            <td><b>{{ number_format($cr,2) }}</b></td>
 <td></td>
                    </tr> 

                      <tr>     
                        <td >
                             <b>{{$account_code->account_name }} Total Balance</b></td>
                             <td colspan="3"><b>{{ number_format($cr-$dr,2) }}</b></td>

                    </tr> 
 
 
<?php
}
?>
                             
                              </tbody>
                            </table>
                           </div>

        </div>
       
 <div class="modal-footer ">
         <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>
    </div>
</div></div>
  </div>
 @endforeach
 @endforeach              
  @endforeach

<!-- sehemu ya liabilitty==================================================== -->
                   
 @foreach($liability->where('added_by',auth()->user()->added_by)  as $account_class)
  @foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)  as $group)                             
@foreach($group->accountCodes->where('added_by',auth()->user()->added_by) as $account_code) 

   @if($account_code->account_name != 'Value Added Tax (VAT)')                        
  <!-- Modal -->
  <div class="modal fade "id="view{{$account_code->account_id}}"  tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-lg"><div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"  style="text-align:center;"> {{$account_code->account_codes }} - {{$account_code->account_name }}<h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>


        <div class="modal-body">
  <div class="table-responsive">
                            <table class="table datatable-basic table-striped">
 <?php        
                       if($account_code->account_name == 'Deffered Tax'){
?>
<thead>
                    <tr>
                    <th>Account Name</th>
                        <th>Account Codes</th>
                          <th>Balance</th>
         
                    </tr>
                    </thead>
                              <tbody>
 <tr>
                        <td colspan="3" style="text-align: left"><b>Income</b></td>
                    </tr>

  <?php   
$total_incomes_deff   = 0;
$total_other_incomes_deff   = 0;
$cost_balance_deff   = 0;
$total_cost_deff   = 0;
$expense_balance_deff   = 0;
$total_expense_deff   = 0;
$gross_deff   = 0;
$profit_deff =0;
$tax_deff =0;
$net_profit_deff =0;
$total_debit_income_balance_deff  =0 ;
 $total_credit_income_balance_deff   =0 ;
  $total_debit_other_income_balance_deff    =0 ;
  $total_credit_other_income_balance_deff   =0 ;
   $total_debit_cost_balance_deff    =0 ;
   $total_credit_cost_balance_deff   =0 ;
   $total_debit_expense_balance_deff    =0 ;
   $total_credit_expense_balance_deff   =0 ;
$gross_dr_deff   = 0;
$gross_cr_deff   = 0;
$tax_dr_deff =0;
$tax_cr_deff =0;
$profit_dr_deff =0;
$profit_cr_deff =0;   
$net_profit_dr_deff =0;
$net_profit_cr_deff =0;   

foreach($income->where('added_by',auth()->user()->added_by) as $account_class_modal){
foreach($account_class_modal->groupAccount->where('added_by',auth()->user()->added_by)  as $group_modal) {  
if($group_modal->group_id != 5110){
foreach($group_modal->accountCodes->where('added_by',auth()->user()->added_by) as $account_code_modal){
     
     
                         $cr_deff = \App\Models\JournalEntry::where('account_id', $account_code_modal->account_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_deff  = \App\Models\JournalEntry::where('account_id', $account_code_modal->account_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');

                         $total_debit_income_balance_deff  +=$dr_deff  ;
                         $total_credit_income_balance_deff  +=$cr_deff ;

                          $income_balance_deff =$dr_deff - $cr_deff ;
                          $total_incomes_deff +=$income_balance_deff  ;
                          ?>
<tr>
  <td>{{$account_code_modal->account_name }}</td>
<td>{{$account_code_modal->account_codes }}</td>
  <td>{{ number_format(abs($income_balance_deff),2) }}</td>
</tr>                
  <?php  

    }}}}           
?>

<tr>
                        <td >
                            <b>Total Income</b></td>
                       <td></td>
                            <td>{{ number_format(abs($total_incomes_deff),2) }}</td>                           
                    </tr> 

<!--
 <tr>
                        <td colspan="3" style="text-align: left"><b>Financial Cost</b></td>
                    </tr>
  <?php  
foreach($cost->where('added_by',auth()->user()->added_by) as $account_class_modal){
foreach($account_class_modal->groupAccount->where('added_by',auth()->user()->added_by)  as $group_modal) {
if($group->group_id == 6180){
foreach($group_modal->accountCodes->where('added_by',auth()->user()->added_by) as $account_code_modal){


                   $cr_deff  = \App\Models\JournalEntry::where('account_id', $account_code_modal->account_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_deff  = \App\Models\JournalEntry::where('account_id', $account_code_modal->account_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                        $total_debit_cost_balance_deff    +=$dr_deff  ;
                         $total_credit_cost_balance_deff   +=$cr_deff ;

                        $cost_balance_deff =$dr_deff - $cr_deff ;
                        $total_cost_deff +=$cost_balance_deff  ;

  ?>
<tr>
  <td>{{$account_code_modal->account_name }}</td>
<td>{{$account_code_modal->account_codes }}</td>
  <td>{{ number_format(abs($cost_balance_deff),2) }}</td>
</tr>                
  <?php  

                            
}}}}
?>

<tr>
                        <td >
                             <b>Total Financial Cost</b></td>
                       <td></td>
      <td>{{ number_format(abs($total_cost_deff),2) }}</td>
                    </tr> 
-->
  <?php  

if($total_other_incomes_deff < 0){
$total_o_deff=$total_other_incomes_deff * -1;
}
else if($total_other_incomes_deff >= 0){
$total_o_deff=$total_other_incomes_deff ;
}


if($total_incomes_deff < 0){
$total_s_deff=$total_incomes_deff * -1;
$gross_deff=$total_s_deff+$total_o_deff-$total_cost_deff;
}
else if($total_incomes_deff >= 0){
$gross_deff=$total_incomes_deff+$total_o_deff-$total_cost_deff;
}



?>
<!--
  <tr>
                        <td >
                            <b>Gross Profit</b></td>
                    <td></td>
                            <td><b>{{ number_format($gross_deff ,2) }}</b></td>
                    </tr> 
-->
<tr>
                        <td colspan="3" style="text-align: left"><b>Expenses</b></td>
                    </tr>
  <?php  
foreach($expense->where('added_by',auth()->user()->added_by) as $account_class_modal){
foreach($account_class_modal->groupAccount->where('added_by',auth()->user()->added_by)  as $group_modal)  {      
if($group->group_id != 6180){
foreach($group_modal->accountCodes->where('added_by',auth()->user()->added_by) as $account_code_modal){

                   $cr_deff  = \App\Models\JournalEntry::where('account_id', $account_code_modal->account_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_deff  = \App\Models\JournalEntry::where('account_id', $account_code_modal->account_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                           $total_debit_expense_balance_deff    +=$dr_deff  ;
                         $total_credit_expense_balance_deff   +=$cr_deff ;

                $expense_balance_deff =$dr_deff - $cr_deff ;
                $total_expense_deff +=$expense_balance_deff  ;
                          
  ?>
  <tr>
  <td>{{$account_code_modal->account_name }}</td>
<td>{{$account_code_modal->account_codes }}</td>
  <td>{{ number_format(abs($expense_balance_deff ),2) }}</td>
       </tr>             
  <?php  

}}}}

?>

<tr>
                        <td >
                             <b>Total Expenses</b></td>
                       <td></td>
                               <td>{{ number_format($total_expense_deff ,2) }}</td>
                    </tr> 

  <?php  

if($gross_deff  < 0){
$profit_deff =$gross_deff + $total_expense_deff ;
}
else if($gross_deff  < 0 &&  $total_expense_deff   < 0){
$profit_deff =$gross_deff + $total_expense_deff ;
}
else if($gross_deff  >= 0 &&  $total_expense_deff   < 0){
$profit_deff = $total_expense_deff  +$gross_deff ;
}
else{
$profit_deff =$gross_deff -$total_expense_deff ;
}


if($profit_deff > 0){
$tax_deff =$profit_deff *0.3;
}

?>

<tr>
                        <td>
                           <b>Profit Before Tax</b></td>
                            <td></td>
                                 <td><b>{{ number_format($profit_deff ,2) }}</b></td>
                    </tr>
                     <tr>
                       <td colspan=2>
                           <b>{{$account_code->account_name }} Total Balance</b></td>
                               <td colspan=2><b>{{ number_format($tax_deff ,2) }}</b></td>
                    </tr>
                   


  <?php  
}

else{   
  ?>
<thead>
                    <tr >
                       <th>Date</th>
                          <th>Debit</th>
                        <th>Credit</th>
           <th>Note</th>
                    </tr>
                    </thead>
                              <tbody>   
 <?php
                        $account = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->orderBy('date','asc')->get();
                        ?>  
                 @foreach($account  as $a)
                                 <tr>
                        <td >{{$a->date }}</td>
                          <td>{{ number_format($a->debit ,2) }}</td>
                   <td >{{ number_format($a->credit ,2) }}</td>
                 <td >{{ $a->notes }}</td>
                    </tr> 

  @endforeach
    
 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');

                        ?>  
                       <tr>     
                        <td >
                             <b>Total Balance</b></td>
                           <td><b>{{ number_format($dr,2) }}</b></td>
                            <td><b>{{ number_format($cr,2) }}</b></td>
 <td></td>
                    </tr> 

                      <tr>     
                        <td >
                             <b>{{$account_code->account_name }} Total Balance</b></td>
                             <td colspan="3"><b>{{ number_format($cr-$dr,2) }}</b></td>
                    </tr> 
 
 
<?php
}
?>
                              </tbody>
                            </table>
                           </div>

        </div>
       
 <div class="modal-footer ">
         <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>
    </div>
</div></div>
  </div>
@else
 <!-- Modal -->
  <div class="modal fade " id="vat{{$account_code->account_id}}"  tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-lg"><div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"  style="text-align:center;"> {{$account_code->account_codes }} - {{$account_code->account_name }}<h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>


        <div class="modal-body">
  <div class="table-responsive">
                            <table class="table datatable-basic table-striped"><h4>VAT IN </h4>
<thead>
                    <tr>
                       <th>Date</th>
                            <th>Debit</th>
                        <th>Credit</th>
                      <th>Note</th>
                    </tr>
                    </thead>
 <tbody>   
 <?php
                         $vat_in = \App\Models\AccountCodes::where('account_name', 'VAT IN')->where('added_by',auth()->user()->added_by)->first();
                        $account = \App\Models\JournalEntry::where('account_id', $vat_in->account_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->orderBy('date','asc')->get();
                            
                       
                        ?>  
                 @foreach($account  as $a)
                                 <tr>
                        <td >{{$a->date }}</td>
                          <td>{{ number_format($a->debit ,2) }}</td>
                   <td >{{ number_format($a->credit ,2) }}</td>
                       <td >{{ $a->notes }}</td>
                    </tr> 

                @endforeach
                
            
    
 <?php
                   
                        $cr_in = \App\Models\JournalEntry::where('account_id',  $vat_in->account_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_in = \App\Models\JournalEntry::where('account_id',  $vat_in->account_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                       $vat_in= $dr_in- $cr_in;


                        ?>  
                    <tr>     
                        <td >
                            <b>Total</b></td>
                           <td><b>{{ number_format($dr_in,2) }}</b></td>
                            <td><b>{{ number_format($cr_in,2) }}</b></td>
                             <td></td>
                             
                    </tr> 
 
                        </tbody>
                            </table>


                            <table class="table datatable-basic table-striped"><h4>VAT OUT </h4>
<thead>
                    <tr>
                       <th>Date</th>
                            <th>Debit</th>
                        <th>Credit</th>
                      <th>Note</th>
                    </tr>
                    </thead>
 <tbody>   
 <?php
                         $vat_out = \App\Models\AccountCodes::where('account_name', 'VAT OUT')->first();
                        $account_out = \App\Models\JournalEntry::where('account_id', $vat_out->account_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->orderBy('date','asc')->get();
                            
                       
                        ?>  
                 @foreach($account_out  as $a_out)
                                 <tr>
                        <td >{{$a_out->date }}</td>
                          <td>{{ number_format($a_out->debit ,2) }}</td>
                   <td >{{ number_format($a_out->credit ,2) }}</td>
                       <td >{{ $a_out->notes }}</td>
                    </tr> 

                @endforeach
                
            
    
 <?php
                   
                        $cr_out = \App\Models\JournalEntry::where('account_id',  $vat_out->account_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_out = \App\Models\JournalEntry::where('account_id',  $vat_out->account_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');

                            $vat_out=$cr_out-$dr_out;


                        ?>  
                    <tr>     
                        <td >
                            <b>Total</b></td>
                           <td><b>{{ number_format($dr_out,2) }}</b></td>
                            <td><b>{{ number_format($cr_out,2) }}</b></td>
                             <td></td>
                             
                    </tr> 

                        </tbody>
                            </table>


                            <table class="table datatable-basic table-striped">

 <tbody>   

  <tr>
                        <td >
                              <b>{{$account_code->account_name }} Total Balance</b></td>    
                                                          @if ($total_in - $total_out < 0)
                                    <td> </td>
                                        <td><b>{{ number_format(abs($vat_in - $vat_out) ,2) }} </b>  </td>
                                
                           @else
                                  <td><b>{{ number_format(abs($vat_in - $vat_out) ,2) }} </b> </td>
                                <td> </td>
                           @endif 
                       

                       

                    </tr> 
                        </tbody>
                            </table>
                           </div>

        </div>
       
 <div class="modal-footer ">
         <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>
    </div>
</div></div>
  </div>
@endif
 @endforeach
 @endforeach              
  @endforeach

@endif

@endsection

@section('scripts')
<script>
       $('.datatable-basic').DataTable({
            autoWidth: false,
            "columnDefs": [
                {"targets": [3]}
            ],
           dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            "language": {
               search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Show:</span> _MENU_',
             paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
            },
        
        });
    </script>

@endsection