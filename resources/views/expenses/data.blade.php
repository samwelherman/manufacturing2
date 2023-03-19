@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Payments</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Payments
                                    List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Payments</a>
                            </li>
                         <li class="nav-item">
                                <a class="nav-link " id="multiple-tab2" data-toggle="tab"
                                    href="#multiple2" role="tab" aria-controls="home" aria-selected="true">Add Multiple Payments
                                   </a>
                            </li>
                    <li class="nav-item">
                                <a class="nav-link  " id="importExel-tab"
                                    data-toggle="tab" href="#importExel" role="tab" aria-controls="profile"
                                    aria-selected="false">Import Payments</a>
                            </li>
                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="table-responsive">
                                
                                <button onclick="exportTableToCSV('payments.csv')"><span>
                                            <i class="icon-folder-download mr-3 icon-2x"></i>Export Table To CSV File
                                        </span></button>

                                  <table class="table datatable-basic table-striped">
                                       <thead>
                                            <tr>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Browser: activate to sort column ascending"
                                                    style="width: 28.531px;">#</th>

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 126.484px;">Reference</th>
                                               
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Expense Account</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Payment Account</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Amount</th>
                                                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Date</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Actions</th>
                                            </tr>
                                        </thead>
                                         <tbody>
                                            @if(!@empty($expense))
                                            @foreach ($expense as $row)
                                            <tr class="gradeA even" role="row">
                                                <th>{{ $loop->iteration }}</th>
                                                     <td>{{$row->name}}</td>

                                                   @php
                                                 $account=App\Models\AccountCodes::where('id',$row->account_id)->first();
                                                @endphp
                                               @if(!empty($account))
                                                <td>{{$account->account_name}}</td>
                                              @else
                                                <td></td>
                                              @endif

                                                @php
                                                 $bank=App\Models\AccountCodes::where('id',$row->bank_id)->first();
                                                @endphp
                                                <td>{{$bank->account_name}}</td>                                           
                                                  <td>{{number_format($row->amount,2)}} {{$row->exchange_code}}</td>
                                                   <td>{{$row->date}}</td>

                                              @if($row->view == '1')
                                                    <td>
                                         <a  class="nav-link" title="View" data-toggle="modal" class="discount"  href="" onclick="model({{ $row->id }},'view')" value="{{ $row->id}}" data-target="#appFormModal" >View Multiple Payment List</a>
                                    
                             </td>
                                           @else
                                                <td>
                                                    @if($row->status == 0)
                                                   <div class="form-inline">
                                                       
                                                        
<a class="list-icons-item text-primary" title="Edit" onclick="return confirm('Are you sure?')"   href="{{ route("expenses.edit", $row->id)}}"><i class="icon-pencil7"></i></a>&nbsp
                                                       

                                                            {!! Form::open(['route' => ['expenses.destroy',$row->id], 'method' => 'delete']) !!}
                                                           {{ Form::button('<i class="icon-trash"></i>', ['type' => 'submit', 'style' => 'border:none;background: none;', 'class' => 'list-icons-item text-danger', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"]) }}
                                                    {{ Form::close() }}
&nbsp
                                                       
                                                  
                                                 <div class="dropdown">
                                  <a href="#" class="list-icons-item dropdown-toggle text-teal" data-toggle="dropdown"><i class="icon-cog6"></i></a>
                                                                <div class="dropdown-menu">
                                                            <a  class="nav-link" title="Convert to Invoice" onclick="return confirm('Are you sure? you want to confirm')"  href="{{ route('expenses.approve', $row->id)}}">Confirm Payment</a></li>
                                                                        
</div>
                                </div>
</div>
                                                
                                                 
                                                    @endif
                                             

                                                </td>
                                       @endif
                                            </tr>
                                            @endforeach

                                            @endif

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade @if(!empty($id)) active show @endif" id="profile2" role="tabpanel"
                                aria-labelledby="profile-tab2">

                                <div class="card">
                                    <div class="card-header">
                                        @if(empty($id))
                                        <h5>Create Payments</h5>
                                        @else
                                        <h5>Edit Payments</h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                @if(isset($id))
                                                {{ Form::model($id, array('route' => array('expenses.update', $id), 'method' => 'PUT')) }}
                                                @else
                                                {{ Form::open(['route' => 'expenses.store']) }}
                                                @method('POST')
                                                @endif



                                                <div class="form-group row">
                           <label class="col-lg-2 col-form-label">Reference</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="name" 
                                                            value="{{ isset($data) ? $data->name : ''}}"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                
                                                 <div class="form-group row">
                           <label class="col-lg-2 col-form-label">Reference2</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="ref" 
                                                            value="{{ isset($data) ? $data->ref : ''}}"
                                                            class="form-control">
                                                    </div>
                                                </div>

                                               <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Amount</label>
                                                    <div class="col-lg-8">
                                                        <input type="number" name="amount" required
                                                            placeholder=""
                                                            value="{{ isset($data) ? $data->amount : ''}}"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                  <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Date</label>
                                                    <div class="col-lg-8">
                                                        <input type="date" name="date" required
                                                            placeholder=""
                                                           value="{{ isset($data) ? $data->date : date('Y-m-d')}}" {{Auth::user()->can('edit-date') ? '' : 'readonly'}}
                                                            class="form-control">
                                                    </div>
                                                </div>
                                               
                                                <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Expense Account</label>
                                                    <div class="col-lg-8">
                                                <select class="m-b account_id" id="account_id" name="account_id" required>
                                                    <option value="">Select Expense Account</option>                                                    
                                                            @foreach ($chart_of_accounts as $chart)                                                             
                                                            <option value="{{$chart->id}}" @if(isset($data))@if($data->account_id == $chart->id) selected @endif @endif >{{$chart->account_name}}</option>
                                                               @endforeach
                                                             </select>
                                                    </div>
                                                </div>

                                                 @if(!empty($data->supplier_id))
                                  <div class="form-group row" id="supplier" ><label
                                                        class="col-lg-2 col-form-label">Supplier</label>
                                                    <div class="col-lg-8">
                                                <select class="m-b supplier_id" id="supplier_id" name="supplier_id" >
                                                    <option value="">Select Supplier</option>                                                    
                                                            @foreach ($client as $m)                                                             
                                                            <option value="{{$m->id}}" @if(isset($data))@if($data->supplier_id == $m->id) selected @endif @endif >{{$m->name}}</option>
                                                               @endforeach
                                                             </select>
                                                    </div>
                                                </div>
                                      @else
                                      <div class="form-group row" id="supplier" style="display:none;"><label
                                                        class="col-lg-2 col-form-label">Supplier</label>
                                                    <div class="col-lg-8">
                                                <select class="m-b supplier_id" id="supplier_id" name="supplier_id" >
                                                    <option value="">Select Supplier</option>                                                    
                                                            @foreach ($client as $m)                                                             
                                                            <option value="{{$m->id}}" @if(isset($data))@if($data->supplier_id == $m->id) selected @endif @endif >{{$m->name}}</option>
                                                               @endforeach
                                                             </select>
                                                    </div>
                                                </div>
                                            @endif


                                                   <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Payment Account</label>
                                                    <div class="col-lg-8">
                                                       <select class="m-b" id="bank_id" name="bank_id" required>
                                                    <option value="">Select Payment Account</option> 
                                                          @foreach ($bank_accounts as $bank)                                                             
                                                            <option value="{{$bank->id}}" @if(isset($data))@if($data->bank_id == $bank->id) selected @endif @endif >{{$bank->account_name}}</option>
                                                               @endforeach
                                                              </select>
                                                    </div>
                                                </div>
                                               
                                                  <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Notes</label>
                                                    <div class="col-lg-8">
                                                        <textarea name="notes"
                                                            placeholder=""
                                                            class="form-control" rows="2">{{isset($data) ? $data->notes : '' }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                        @if(!@empty($id))
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                            data-toggle="modal" data-target="#myModal"
                                                            type="submit">Update</button>
                                                        @else
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                            type="submit">Save</button>
                                                        @endif
                                                    </div>
                                                </div>
                                                {!! Form::close() !!}
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        <div class="tab-pane fade" id="multiple2" role="tabpanel"
                                aria-labelledby="profile-tab2">

                                <div class="card">
                                    <div class="card-header">
                                       
                                        <h5>Add Multiple Payments</h5>
                                        
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                              
                                                {{ Form::open(['route' => 'expenses.store']) }}
                                                @method('POST')
                                                

                                                    <input type="hidden" name="type" value="multiple"   class="form-control">
                                                            
                                                          

                                                <div class="form-group row">
                           <label class="col-lg-2 col-form-label">Reference</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="name" 
                                                            value="{{ isset($data) ? $data->name : ''}}"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                
                                                 <div class="form-group row">
                           <label class="col-lg-2 col-form-label">Reference2</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="ref" 
                                                            value="{{ isset($data) ? $data->ref : ''}}"
                                                            class="form-control">
                                                    </div>
                                                </div>

                                              
                                                  <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Date</label>
                                                    <div class="col-lg-8">
                                                        <input type="date" name="date" required
                                                            placeholder=""
                                                           value="{{ isset($data) ? $data->date : date('Y-m-d')}}" 
                                                            class="form-control">
                                                    </div>
                                                </div>
                                              

                                                   <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Payment Account</label>
                                                    <div class="col-lg-8">
                                                       <select class="form-control m-b " id="bank2_id" name="bank_id" required>
                                                    <option value="">Select Payment Account</option> 
                                                          @foreach ($bank_accounts as $bank)                                                             
                                                            <option value="{{$bank->id}}" @if(isset($data))@if($data->bank_id == $bank->id) selected @endif @endif >{{$bank->account_name}}</option>
                                                               @endforeach
                                                              </select>
                                                    </div>
                                                </div>
                                               
                                                
                                            <hr>
                                             <button type="button" name="add" class="btn btn-success btn-xs add"><i class="fas fa-plus"> Add item</i></button><br>
                        
                                              <br>
    <div class="table-responsive">
<table class="table table-bordered" id="cart">
            <thead>
              <tr>
                <th>Expense Account</th>
                <th>Amount</th>
                <th>Notes</th>                
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
                                    

</tbody>
</table>
</div>


<br>
                                                <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                        @if(!@empty($id))
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                            data-toggle="modal" data-target="#myModal"
                                                            type="submit">Update</button>
                                                        @else
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                            type="submit">Save</button>
                                                        @endif
                                                    </div>
                                                </div>
                                                {!! Form::close() !!}
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>


                     

                            <div class="tab-pane fade" id="importExel" role="tabpanel"
                            aria-labelledby="importExel-tab">

                            <div class="card">
                                <div class="card-header">
                                     <form action="{{ route('expenses.sample') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <button class="btn btn-success">Download Sample</button>
                                        </form>
                                 
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 ">
                                            <div class="container mt-5 text-center">
                                                <h4 class="mb-4">
                                                 Import Excel & CSV File   
                                                </h4>
                                                <form action="{{ route('expenses.import') }}" method="POST" enctype="multipart/form-data">
                                            
                                                    @csrf
                                                    <div class="form-group mb-4">
                                                        <div class="custom-file text-left">
                                                            <input type="file" name="file" class="form-control" id="customFile" required>
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-primary">Import Payments</button>
                                          
                                        </form>
                                       
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
        </div>

    </div>
</section>

<!-- discount Modal -->
<div class="modal fade" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    </div>
</div>


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
<script>
var minDate, maxDate;
 
// Custom filtering function which will search data in column four between two values
$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var min = minDate.val();
        var max = maxDate.val();
        var date = new Date( data[5] );
 
        if (
            ( min === null && max === null ) ||
            ( min === null && date <= max ) ||
            ( min <= date   && max === null ) ||
            ( min <= date   && date <= max )
        ) {
            return true;
        }
        return false;
    }
);



</script>
<script>
$(document).ready(function() {

    $(document).on('change', '.account_id', function() {
        var id = $(this).val();
  console.log(id);
      
 $.ajax({
            url: '{{url("gl_setup/findSupplier")}}',
            type: "GET",
            data: {
                id: id,
            },
 dataType: "json",
            success: function(data) {
              console.log(data); 
          $("#supplier").css("display", "none");
         if (data == 'OK') {
           $("#supplier").css("display", "block");   
}
     

 }

        });

    });



});

</script>
<script type="text/javascript">
$(document).ready(function() {


    var count = 0;


    


    $('.add').on("click", function(e) {

        count++;
        var html = '';
        html += '<tr class="line_items">';
        html += '<td><br><select name="account_id[]" class="m-b form-control item_name" required  data-sub_category_id="' +count +'"><option value="">Select Expense Account</option>@foreach ($chart_of_accounts as $chart) <option value="{{$chart->id}}">{{$chart->account_name}}</option>@endforeach</select></td>';
        html +='<td><br><input type="number" name="amount[]" class="form-control item_quantity' + count +'"  id ="quantity" value="" required /></td>';
        html += '<td><br><textarea name="notes[]" class="form-control" rows="2"></textarea></td>';
        html +='<td><br><button type="button" name="remove" class="btn btn-danger btn-xs remove"><i class="icon-trash"></i></button></td>';

        $('#cart > tbody').append(html);
      

/*
             * Multiple drop down select
             */
            $(".m-b").select2({
                            });
          


      
    });

    $(document).on('click', '.remove', function() {
        $(this).closest('tr').remove();
        
    });


   

});
</script>
<script type="text/javascript">
function model(id, type) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: 'GET',
      url: '{{url("gl_setup/findInvoice")}}',
        data: {
            'id': id,
            'type': type,
        },
        cache: false,
        async: true,
        success: function(data) {
            //alert(data);
            $('.modal-dialog').html(data);
        },
        error: function(error) {
            $('#appFormModal').modal('toggle');

        }
    });

}


</script>

@endsection