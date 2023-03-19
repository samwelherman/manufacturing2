@extends('layouts.master')
<style>
.p-md {
    padding: 12px !important;
}

.bg-items {
    background: #303252;
    color: #ffffff;
}
.ml-13 {
    margin-left: -13px !important;
}
</style>

@section('content')
<section class="section">
    <div class="section-body">


        <div class="row">


            <div class="col-12 col-md-12 col-lg-12">

               <div class="col-lg-10">
                    @if($purchases->status != 1)
                 <a class="btn btn-xs btn-primary"  onclick="return confirm('Are you sure?')"   href="{{ route('requisition.edit', $purchases->id)}}"  title="" > Edit </a>          
            
                @endif

                 

      @if($purchases->status != 1)                        
              <a class="btn btn-xs btn-info" data-placement="top"  href="{{ route('requisition.receive',$purchases->id)}}"  title="Good Receive"> Good Receive </a>
            <a class="btn btn-xs btn-danger" data-placement="top" onclick="return confirm('Are you sure?')"  href="{{ route('requisition.cancel', $purchases->id)}}""  ]>Cancel </a>   

           @endif  
             
             <a class="btn btn-xs btn-success"  href="{{ route('requisition_pdfview',['download'=>'pdf','id'=>$purchases->id]) }}"  title="" > Download PDF </a>         
                                         
    </div>

<br>
 @if(!empty($purchases->due_date))
<?php if (strtotime($purchases->due_date) < time() && $purchases->status == '0') {
    $start = strtotime(date('Y-m-d H:i'));
    $end = strtotime($purchases->due_date);

    $days_between = ceil(abs($end - $start) / 86400);
    ?>

   <div class="alert alert-danger alert-dismissible show fade">
            <div class="alert-body">
              <button class="close" data-dismiss="alert">
                <span>×</span>
              </button>
             <i class="fa fa-exclamation-triangle"></i>
        This purchase is overdue by {{ $days_between}} days
            </div>
          </div>

  
    <?php
}
?>
@endif
<br>
 
                <div class="card">
                    <div class="padding-20">
                       
                        <?php
$settings= App\Models\System::first();


?>
                        <div class="tab-content" id="myTab3Content">
                            <div class="tab-pane fade show active" id="about" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="row">
                                   <div class="col-lg-5 col-xs-5 ">
                <img class="pl-lg" style="width: 233px;height: 120px;" src="{{url('public/assets/img/logo')}}/{{$settings->picture}}">
            </div>
                                  
 <div class="col-lg-3 col-xs-3">

                                    </div>

                                      <div class="col-lg-4 col-xs-4">
                                        
                                       <h5 class=mb0">REF NO : {{$purchases->reference_no}}</h5>
                                      Purchase Date : {{Carbon\Carbon::parse($purchases->date)->format('d/m/Y')}}                  
              <br>Due Date : {{Carbon\Carbon::parse($purchases->due_date)->format('d/m/Y')}}                                          
           <br>Sales Agent: {{$purchases->user->name }} 
                                      
          <br>Status: 
                                   @if($purchases->status == 0)
                                            <span class="badge badge-danger badge-shadow">Not Approved</span>
                                            @elseif($purchases->status == 1)
                                            <span class="badge badge-success badge-shadow">Approved</span>
                                            @elseif($purchases->status == 4)
                                            <span class="badge badge-danger badge-shadow">Cancelled</span>
                                            @endif
                                       
                                        <br>Currency: {{$purchases->exchange_code }}                                                
                    
                    
                
            </div>
                                </div>


                               <br><br>
                               <div class="row mb-lg">
                                    <div class="col-lg-6 col-xs-6">
                                         <h5 class="p-md bg-items mr-15">Our Info:</h5>
                                 <h4 class="mb0">{{$settings->name}}</h4>
                    {{ $settings->address }}  
                   <br>Phone : {{ $settings->phone}}     
                  <br> Email : <a href="mailto:{{$settings->email}}">{{$settings->email}}</a>                                                               
                   <br>TIN : {{$settings->tin}}
                                    </div>
                                   

                                    <div class="col-lg-6 col-xs-6">
                                     
                                       <h5 class="p-md bg-items ml-13">  Supplier Info: </h5>
                                            @if(!empty($purchases->supplier))
                                       <h4 class="mb0"> {{$purchases->supplier->name}}</h4>
                                      {{$purchases->supplier->address}}   
                                     <br>Phone : {{$purchases->supplier->phone}}                  
                                    <br> Email : <a href="mailto:{{$purchases->supplier->email}}">{{$purchases->supplier->email}}</a>                                                               
                                    <br>TIN : {{!empty($purchases->supplier->TIN)? $purchases->supplier->TIN : ''}}
                                        @endif

                                        </div>
 </div>

                                    </div>
                                </div>

                                
                                <?php
                               
                                 $sub_total = 0;
                                 $gland_total = 0;
                                 $tax=0;
                                 $i =1;
       
                                 ?>

                               <div class="table-responsive mb-lg">
            <table class="table items invoice-items-preview" page-break-inside:="" auto;="">
                <thead class="bg-items">
                    <tr>
                        <th style="color:white;">#</th>
                        <th style="color:white;">Items</th>
                        <th style="color:white;">Qty</th>
                        <th  class="col-sm-1" style="color:white;">Price</th>
                        <th class="col-sm-2" style="color:white;">Tax</th>
                        <th class="col-sm-1" style="color:white;">Total</th>
                    </tr>
                </thead>
                                    <tbody>
                                        @if(!empty($purchase_items))
                                        @foreach($purchase_items as $row)
                                        <?php
                                         $sub_total +=$row->total_cost;
                                         $gland_total +=$row->total_cost +$row->total_tax;
                                         $tax += $row->total_tax; 
                                         ?>
                                        <tr>
                                            <td class="">{{$i++}}</td>
                                            <?php
                                         $item_name = App\Models\Inventory::find($row->item_name);
                                        ?>
                                            <td class=""><strong class="block">{{$item_name->name}}</strong></td>
                                            <td class="">{{ $row->quantity }} </td>
                                        <td class="">{{number_format($row->price ,2)}}  </td>                                         
                                         <td class="">
                                  @if(!@empty($row->total_tax > 0))
                              <small class="pr-sm">VAT ({{ $row->tax_rate * 100 }} %)</small> {{number_format($row->total_tax ,2)}} 
                                    @else
                              {{number_format($row->total_tax ,2)}}
@endif
</td>
                                            <td class="">{{number_format($row->total_cost ,2)}} </td>
                                            
                                        </tr>
                                        @endforeach
                                        @endif

                                       
                                    </tbody>

<tfoot>
<tr>
<td colspan="4"></td>
<td>Sub Total</td>
<td>{{number_format($sub_total,2)}}  {{$purchases->exchange_code}}</td>
</tr>

<tr>
<td colspan="4"></td>
<td>Total Tax <small class="pr-sm">(VAT 18 %)</small></td>
<td>{{number_format($tax,2)}}  {{$purchases->exchange_code}}</td>
</tr>

<tr>
<td colspan="4"></td>
<td>Total Amount</td>
<td>{{number_format($gland_total - $purchases->discount ,2)}}  {{$purchases->exchange_code}}</td>
</tr>

  @if(!@empty($purchases->due_amount < $purchases->purchase_amount + $purchases->purchase_tax))
     <tr>
<td colspan="4"></td>
                    <td>Paid Amount</p>
                    <td>{{number_format(($purchases->amount - $purchases->due_amount),2)}}  {{$purchases->exchange_code}}</p>
                </tr>

      <tr>
<td colspan="4"></td>
                    <td class="text-danger">Total Due</td>
                    <td>{{number_format($purchases->due_amount,2)}}  {{$purchases->exchange_code}}</td>
                </tr>
@endif

<br>
 @if($purchases->exchange_code != 'TZS')
 <tr>
<td colspan="4"></td>
 <td><b>Exchange Rate 1 {{$purchases->exchange_code}} </b></td>
 <td><b> {{$purchases->exchange_rate}} TZS</b></td>
</tr>
<p></p>
<br>
              <tr>
<td colspan="4"></td>
<td>Sub Total</td>
<td>{{number_format($sub_total * $purchases->exchange_rate,2)}}  TZS</td>
</tr>

<tr>
<td colspan="4"></td>
<td>Total Tax <small class="pr-sm">(VAT 18 %)</small></td>
<td>{{number_format($tax * $purchases->exchange_rate,2)}}   TZS</td>
</tr>

<tr>
<td colspan="4"></td>
<td>Total Amount</td>
<td>{{number_format($purchases->exchange_rate * ($gland_total-$purchases->discount) ,2)}}   TZS</td>
</tr>

 @if(!@empty($purchases->due_amount < $purchases->purchase_amount + $purchases->purchase_tax))
     <tr>
<td colspan="4"></td>
                    <td>Paid Amount</p>
                    <td>{{number_format($purchases->exchange_rate * ($purchases->amount  - $purchases->due_amount),2)}}  TZS</p>
                </tr>

      <tr>
<td colspan="4"></td>
                    <td class="text-danger">Total Due</td>
                    <td>{{number_format(($purchases->due_amount * $purchases->exchange_rate),2)}}  TZS</td>
                </tr>
@endif
@endif
</tfoot>
</table>
                            </div>

                                     
                             
                            </div>

                        </div>

                    </div>
                </div>
            </div>

         

</section>


   
@endsection

@section('scripts')

@endsection