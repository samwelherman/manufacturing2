@extends('layouts.master')


@section('content')


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
  <script>
    jQuery(document).ready(function($) {
      $('#example').DataTable(
        {
        dom: 'Bfrtip',
        buttons: [
                    'copy',
                    'excel',
                    'csv',
                    'pdf',
                    'print'
                ],
        }
      );
     
    } );
    </script>
    
    
    
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Truck Report</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Truck Report
                                    List</a>
                            </li>
                       

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">

<br>
@php
$center=App\Models\Truck::where('id',$account_id)->first();
@endphp

        <div class="panel-heading">
            <h6 class="panel-title">
             Truck Report
                @if(!empty($start_date))
                    for the period: <b>{{$start_date}} to {{$end_date}} for {{$center->truck_name}} - {{$center->reg_no}}</b>
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
                    <label class="">Truck Name</label>
                    {!! Form::select('account_id',$chart_of_accounts,$account_id, array('class' => 'form-control  m-b','id'=>'account_id','placeholder'=>'Select','style'=>'width:100%','required'=>'required')) !!}
                </div>

   <div class="col-md-12">
                      <br><button type="submit" class="btn btn-success">Search</button>
                        <a href="{{Request::url()}}"class="btn btn-danger">Reset</a>
                   @if(!empty($start_date))
                        <a class="btn btn-primary" href="{{ route('truck_report',['account_id'=>isset($account_id)? $account_id : '','start_date'=>isset($start_date)? $start_date : '','end_date'=>isset($end_date)? $end_date: '' ,'type'=>'print_pdf']) }}"  title="" > Download PDF </a>      
                      @endif

                </div>                  
                </div>
           
            {!! Form::close() !!}

        </div>

        <!-- /.panel-body -->

   <br> <br>
@if(!empty($start_date))
        <div class="panel panel-white">
            <div class="panel-body ">
                <div class="table-responsive">

                    <table class="table table-striped" id="example" style="width:100%;">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th> Date</th>
                        <th> Account Name</th>
                            <th>Debit </th>
                            <th>Credit</th>
                    <th>Balance</th>
                            <th>Notes</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($data as $key)
                          <?php
                        $cr = 0;
                        $dr = 0;
                   
                        $cr = \App\Models\JournalEntry::where('truck_id', $account_id)->whereBetween('date',
                            [$start_date, $end_date])->sum('credit');
                        $dr = \App\Models\JournalEntry::where('truck_id', $account_id)->whereBetween('date',
                            [$start_date, $end_date])->sum('debit');
                      
                        ?>
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                  <td>{{Carbon\Carbon::parse($key->date)->format('d/m/Y')}} </td>
                                    <td>{{ $key->chart->name }}</td>
                                    <td>{{ number_format($key->debit,2) }}</td>
                                <td>{{ number_format($key->credit,2) }}</td>  
                    <td>{{ number_format($key->debit - $key->credit,2) }}</td>                                
                             <td>{{ $key->notes }}</td>
                                
                            </tr>
                        
                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="custom-color-with-td">
                                   <td></td>  <td></td>  
                                <td ><b>Total</b></td>
                                <td><b>{{ number_format($dr,2) }}</b></td>
                                   
                                     <td><b>{{ number_format($cr,2) }}</b></td>
                                    <td><b>{{ number_format($dr-$cr,2) }}</b></td>
                          <td></td>
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