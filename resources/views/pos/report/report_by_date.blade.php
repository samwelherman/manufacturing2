@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Report By Date</h4>
                    </div>
                    <div class="card-body">
                       
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">

<br>
        <div class="panel-heading">
            <h6 class="panel-title">
                
                @if(!empty($start_date))
                    For the period: <b>{{Carbon\Carbon::parse($start_date)->format('d/m/Y')}}  to {{Carbon\Carbon::parse($end_date)->format('d/m/Y')}}</b>
                @endif
            </h6>
        </div>

<br>
        <div class="panel-body hidden-print">
            {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form')) !!}
            <div class="row">

               <div class="col-md-4">
                    <label class="">Start Date</label>
                   <input  name="start_date" type="date" class="form-control date-picker" required value="<?php
                if (!empty($start_date)) {
                    echo $start_date;
                } else {
                    echo date('Y-m-d', strtotime('first day of january this year'));
                }
                ?>">

                </div>
                <div class="col-md-4">
                    <label class="">End Date</label>
                     <input  name="end_date" type="date" class="form-control date-picker" required value="<?php
                if (!empty($end_date)) {
                    echo $end_date;
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
@if(!empty($start_date))
        <div class="panel panel-white">
            <div class="panel-body ">
                <div class="table-responsive">

                  <table class="table datatable-button-html5-basic">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                              <th>Purchase Balance</th>
                               <th>Sales Balance</th>
                            <th>Total Balance</th>
                        </tr>
                        </thead>
                        <tbody>

                          <?php
            $total_p=0; 
             $total_s=0;
             $total_pr=0; 
             $total_sr=0;
             $total_i=0;      
                 $i=0;  
?>

                        @foreach($data as $key)
                               @php
                                      $pqty= App\Models\POS\PurchaseHistory::where('item_id', $key->id)->where('type', 'Purchases')->whereBetween('purchase_date',[$start_date,$end_date])->sum('quantity');   
                                        $dn= App\Models\POS\PurchaseHistory::where('item_id', $key->id)->where('type', 'Debit Note')->whereBetween('purchase_date',[$start_date,$end_date])->sum('quantity');  
                                       $sqty= App\Models\POS\InvoiceHistory::where('item_id', $key->id)->where('type', 'Sales')->whereBetween('invoice_date',[$start_date,$end_date])->sum('quantity'); 
                                          $cn= App\Models\POS\InvoiceHistory::where('item_id', $key->id)->where('type', 'Credit Note')->whereBetween('invoice_date',[$start_date,$end_date])->sum('quantity');  
                                        @endphp 

                               @if($pqty-$dn > 0 || $sqty-$cn > 0 )

                            <?php   $i++;  ?>

                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                 <td>{{$key->name}}</td>

                                 @php
                                      $total_p+=$pqty ;                                        
                                        $total_pr+=$dn;
                                          $total_s+=$sqty;
                                        $total_sr+=$cn ;;
                                        @endphp 

                           <td><a  href="#viewp{{$key->id}}"  data-toggle="modal" >{{number_format($pqty-$dn,2)}}</a></td>
                                 <td><a  href="#views{{$key->id}}"  data-toggle="modal" >{{number_format($sqty-$cn,2)}}</a></td>     
                              <td>{{number_format(($pqty-$dn)-($sqty-$cn),2)}}</td>                          
                            </tr>

                        @endif
                        @endforeach
                        </tbody>
                        <tfoot>
                           <tr>
                                <td>Total</td>
                     <td></td>
                           <td>{{number_format($total_p - $total_pr,2)}}</td>
                                <td>{{number_format($total_s - $total_sr,2)}}</td>
                       <td>{{number_format(($total_p- $total_pr) -($total_s- $total_sr),2)}}</td>                               
                            </tr>
                        </tfoot>
                    </table>
                  
                </div>
            </div>
            <!-- /.panel-body -->
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

 <!-- Modal -->
@foreach($data as $key)
  <div class="modal fade " data-backdrop=""  id="viewp{{$key->id}}"  tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-lg"><div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"  style="text-align:center;"> {{$key->name}} Purchase Balance<h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>


        <div class="modal-body">
  <div class="table-responsive">
                           <table class="table datatable-basic table-striped">
                                       <thead>
                                            <tr>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Browser: activate to sort column ascending"
                                                    style="width: 30.531px;">#</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 50.484px;">Type</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 110.484px;">Date</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 120.484px;">Ref No</th>                                               
                                              <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 160.484px;">Supplier</th>
                                                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 100.484px;">Location</th>
                                                     <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 100.484px;">Quantity</th>
                                             
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php                   
                                                $account =App\Models\POS\PurchaseHistory::where('item_id', $key->id)->whereBetween('purchase_date',[$start_date,$end_date])->orderBy('purchase_date','desc')->get();
                                                ?>  
                                         @foreach($account  as $a)
                                                         <tr>
                                              <td >{{$loop->iteration }}</td>
                                              <td >{{$a->type }}</td>
                                              @if($a->type == 'Purchases')
                                              <td >{{$a->purchase_date }}</td>
                                               @else
                                                    <td >{{$a->return_date }}</td>
                                                   @endif
                                                  <td >@if(!empty($a->purchase_id)) {{$a->purchase->reference_no }} @endif</td>
                          <td >@if(!empty($a->supplier_id)){{$a->supplier->name }}@endif</td>
                   <td >@if(!empty($a->location)){{$a->store->name }}@endif</td>
                                           @if($a->type == 'Purchases')
                                           <td >{{ number_format($a->quantity ,2) }}</td>
                                           @else
                                                  <td >{{ number_format(0-$a->quantity ,2) }}</td>
                                               @endif
                                            </tr> 
                        
                          @endforeach
                            </tbody>
                         
                         <?php
                                           
                                                $q = App\Models\POS\PurchaseHistory::where('item_id', $key->id)->where('type', 'Purchases')->whereBetween('purchase_date',[$start_date,$end_date])->sum('quantity');
                                                $r = App\Models\POS\PurchaseHistory::where('item_id', $key->id)->where('type', 'Debit Note')->whereBetween('purchase_date',[$start_date,$end_date])->sum('quantity');
                                            
                                                ?>  
                        <tfoot>
                                            <tr>     
                                                <td ></td> <td ></td>
                                                     <td></td> <td></td>
                                                   <td></td>  <td><b> Total Balance</b></td>
                                                    <td><b>{{ number_format($q-$r,2) }}</b></td>
                                                
                                            </tr> 
                        
                                              
                         
                                                      </tfoot>
                            </table>
                           </div>

        </div>
        <div class="modal-footer bg-whitesmoke br">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
    </div>
</div></div>
  </div>

@endforeach


@foreach($data as $key)
  <div class="modal fade " data-backdrop=""  id="views{{$key->id}}"  tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-lg"><div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"  style="text-align:center;"> {{$key->name}} Sales Balance<h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>


        <div class="modal-body">
  <div class="table-responsive">
                           <table class="table datatable-basic table-striped">
                                       <thead>
                                            <tr>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Browser: activate to sort column ascending"
                                                    style="width: 30.531px;">#</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 50.484px;">Type</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 110.484px;">Date</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 120.484px;">Ref No</th>                                               
                                              <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 160.484px;">Client</th>
                                          <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 100.484px;">Location</th>

                                                     <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 100.484px;">Quantity</th>
                                             
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php                   
                                                $account =App\Models\POS\InvoiceHistory::where('item_id', $key->id)->whereBetween('invoice_date',[$start_date,$end_date])->orderBy('invoice_date','desc')->get();
                                                ?>  
                                         @foreach($account  as $a)
                                                         <tr>
                                              <td >{{$loop->iteration }}</td>
                                               <td >{{$a->type }}</td>
                                                @if($a->type == 'Sales')
                                                <td >{{$a->invoice_date }}</td>
                                                 @else
                                                      <td >{{$a->return_date }}</td>
                                                     @endif
                                                  <td >{{$a->invoice->reference_no }}</td>
                                                  <td >{{$a->client->name }}</td>
                                           <td >@if(!empty($a->location)){{$a->store->name }}@endif</td>
                                                       @if($a->type == 'Sales')
                                                 <td >{{ number_format($a->quantity ,2) }}</td>
                                                 @else
                                                        <td >{{ number_format(0-$a->quantity ,2) }}</td>
                                                     @endif
                                           
                                            </tr> 
                        
                          @endforeach
                            </tbody>
                         
                         <?php
                                           
                                                $q = App\Models\POS\InvoiceHistory::where('item_id', $key->id)->where('type', 'Sales')->whereBetween('invoice_date',[$start_date,$end_date])->sum('quantity');
                                                 $r = App\Models\POS\InvoiceHistory::where('item_id', $key->id)->where('type', 'Credit Note')->whereBetween('invoice_date',[$start_date,$end_date])->sum('quantity');
                                                ?>  
                        <tfoot>
                                            <tr>     
                                                <td ></td> <td ></td>
                                                     <td></td>   <td></td><td></td>
                                                 <td><b> Total Balance</b></td>
                                                    <td><b>{{ number_format($q-$r,2) }}</b></td>
                                                
                                            </tr> 
                        
                                              
                         
                                                      </tfoot>
                            </table>
                           </div>

        </div>
        <div class="modal-footer bg-whitesmoke br">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
    </div>
</div></div>
  </div>

@endforeach


@endsection

@section('scripts')


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.3.4/css/buttons.dataTables.min.css">

    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.3.4/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.html5.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
<script>

      $('.datatable-button-html5-basic').DataTable(
        {
        dom: 'Bfrtip',

        buttons: [
          {extend: 'copyHtml5',title: 'REPORT BY DATE FOR THE PERIOD {{Carbon\Carbon::parse($start_date)->format('d-m-Y')}} TO {{Carbon\Carbon::parse($end_date)->format('d-m-Y')}} ', footer: true},
           {extend: 'excelHtml5',title: 'REPORT BY DATE FOR THE PERIOD {{Carbon\Carbon::parse($start_date)->format('d-m-Y')}} TO {{Carbon\Carbon::parse($end_date)->format('d-m-Y')}}' , footer: true},
           {extend: 'csvHtml5',title: 'REPORT BY DATE FOR THE PERIOD {{Carbon\Carbon::parse($start_date)->format('d-m-Y')}} TO {{Carbon\Carbon::parse($end_date)->format('d-m-Y')}}' , footer: true},
            {extend: 'pdfHtml5',title: 'REPORT BY DATE FOR THE PERIOD {{Carbon\Carbon::parse($start_date)->format('d-m-Y')}} TO {{Carbon\Carbon::parse($end_date)->format('d-m-Y')}}', footer: true,customize: function(doc) {
doc.content[1].table.widths = [ '8%', '32%', '20%', '20%','20%'];
}
},
            {extend: 'print',title: 'REPORT BY DATE FOR THE PERIOD {{Carbon\Carbon::parse($start_date)->format('d-m-Y')}} TO {{Carbon\Carbon::parse($end_date)->format('d-m-Y')}}' , footer: true}

                ],
        }
      );
     
    </script>
<script>
       $('.datatable-basic').DataTable({
            autoWidth: false,
            "columnDefs": [
                {"orderable": false, "targets": [1]}
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
<script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>

@endsection