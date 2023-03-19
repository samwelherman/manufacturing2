@extends('layouts.master')


@section('content')
    

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Journal Entry Report</h4>
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
                    <label class="">Chart of Accounts</label>
                    
                    {!! Form::select('account_id',$chart_of_accounts,$account_id, array('class' => 'form-control m-b','id'=>'account_id', 'placeholder'=>'Select','required'=>'required')) !!}
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
                            <th> Type</th>
                            <th>Date</th>
                            <th>Account Name</th>
                            <th>Debit</th>
                            <th>Credit</th>
                     <th>Notes</th>
                        </tr>
                        </thead>
                        <tbody>
<?php
$dr=0;
$cr=0;
?>
                        @foreach($data as $key)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{$key->transaction_type}}</td>
                                <td>{{ $key->date }}</td>
                                <td>
                                    @if(!empty($key->chart))
                                        {{ $key->chart->account_name }}
                                    @endif
                                </td>
                                 
                                <td>{{ number_format($key->debit,2) }}</td>
                                <td>{{ number_format($key->credit,2) }}</td>
                                 <td>{{ $key->notes }}</td>
                            </tr>
<?php
$dr+=$key->debit;
$cr+=$key->credit;
?>
                        @endforeach
                        </tbody>
 <tfoot>
                            <tr class="custom-color-with-td">
                                   <td></td>  <td></td> <td></td>  
                                <td ><b>Total</b></td>
                                <td><b>{{ number_format($dr,2) }}</b></td>
                                   <td><b>{{ number_format($cr,2) }}</b></td>
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
          {extend: 'copyHtml5',title: 'JOURNAL ENTRY REPORT FOR THE PERIOD {{Carbon\Carbon::parse($start_date)->format('d-m-Y')}} TO {{Carbon\Carbon::parse($end_date)->format('d-m-Y')}} ', footer: true},
           {extend: 'excelHtml5',title: 'JOURNAL ENTRY REPORT FOR THE PERIOD {{Carbon\Carbon::parse($start_date)->format('d-m-Y')}} TO {{Carbon\Carbon::parse($end_date)->format('d-m-Y')}}' , footer: true},
           {extend: 'csvHtml5',title: 'JOURNAL ENTRY REPORT FOR THE PERIOD {{Carbon\Carbon::parse($start_date)->format('d-m-Y')}} TO {{Carbon\Carbon::parse($end_date)->format('d-m-Y')}}' , footer: true},
            {extend: 'pdfHtml5',title: 'JOURNAL ENTRY REPORT FOR THE PERIOD {{Carbon\Carbon::parse($start_date)->format('d-m-Y')}} TO {{Carbon\Carbon::parse($end_date)->format('d-m-Y')}}', footer: true,
           
},
            {extend: 'print',title: 'JOURNAL ENTRY REPORT FOR THE PERIOD {{Carbon\Carbon::parse($start_date)->format('d-m-Y')}} TO {{Carbon\Carbon::parse($end_date)->format('d-m-Y')}}' , footer: true}

                ],
        }
      );
     
    </script>


 <script>
        $(document).ready(function(){
            /*
                         * Multiple drop down select
                         */
            $('.m-b').select2({ width: '100%', });



        });
    </script>

@endsection