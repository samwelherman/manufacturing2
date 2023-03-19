@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Journal Entry</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Journal Entry
                                    List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Journal Entry</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link  " id="importExel-tab"
                                    data-toggle="tab" href="#importExel" role="tab" aria-controls="profile"
                                    aria-selected="false">Import</a>
                            </li>

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="table-responsive">
                               
                                    <table class="table datatable-button-html5-basic">
                                       <thead>
                                            <tr>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Browser: activate to sort column ascending"
                                                    style="width: 28.531px;">#</th>

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 106.484px;">Account Codes</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Account Name</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Debit</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Credit</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Date</th>
                                            </tr>
                                        </thead>
                                         <tbody>
                                            @if(!@empty($journal))
                                            @foreach ($journal as $row)
                                            <tr class="gradeA even" role="row">
                                                <th>{{ $loop->iteration }}</th>
                                                  @if(!empty($row->chart))
                                                <td>{{$row->chart->account_codes}}</td>
                                                <td>{{$row->chart->account_name}}</td>
                                                     @endif
                                                <td>{{number_format($row->debit,2)}}</td>                                           
                                                  <td>{{number_format($row->credit,2)}}</td>
                                                    <td>{{Carbon\Carbon::parse($row->date)->format('d/m/Y')}}</td>
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
                                        <h5>Create Journal Entry</h5>
                                     
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                            
                                                {{ Form::open(['url' => url('accounting/manual_entry/store')]) }}
                                                @method('POST')
                                            

                                              
                                         <div class="form-group row">
                                             <label class="col-lg-2 col-form-label">Type</label>
                                                    <div class="col-lg-8">
                                                <select class="form-control m-b type" id="type" name="type" >
                                                    <option value="">Select </option>                                                    
                                                          <option value="Client">Client </option> 
                                                           <option value="Supplier">Supplier</option> 
                                                                <option value="Other">Other </option> 
                                                             </select>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                           <label class="col-lg-2 col-form-label">Amount</label>
                                                    <div class="col-lg-8">
                                                        <input type="number" name="amount" required
                                                           
                                                            class="form-control">
                                                    </div>
                                                </div>

                                               <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Date</label>
                                                    <div class="col-lg-8">
                                                        <input type="date" name="date" required {{Auth::user()->can('edit-date') ? '' : ''}}
                                                            placeholder=""
                                                            value="{{ isset($data) ? $data->date : date("Y-m-d")}}"
                                                           
                                                            class="form-control date-picker">
                                                    </div>
                                                </div>
                                               
                                                <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Debit</label>
                                                    <div class="col-lg-8">                                          
                    {!! Form::select('debit_account_id',$chart_of_accounts,null, array('class' => 'form-control m-b debit','id'=>'account_id', 'placeholder'=>"Select Debit",'required'=>'')) !!}                                                      
                                                    </div>
                                                </div>

                                                <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Credit</label>
                                                    <div class="col-lg-8">  
                                                                                
                    {!! Form::select('credit_account_id',$chart_of_accounts,null, array('class' => 'form-control m-b credit', 'placeholder'=>"Select Credit",'style'=>'width:100%','id'=>'account_id_credit','required'=>'')) !!}                                                      
                                                    </div>
                                                </div>

                                         <div class="form-group row" id="client" style="display:none;"><label
                                                        class="col-lg-2 col-form-label">Client</label>
                                                    <div class="col-lg-8">
                                                <select class="m-b client_id" id="client_id" name="client_id" >
                                                    <option value="">Select Client</option>                                                    
                                                            @foreach ($client as $c)                                                             
                                                            <option value="{{$c->id}}">{{$c->name}}</option>
                                                               @endforeach
                                                             </select>
                                                    </div>
                                                </div>

                                            <div class="form-group row" id="supplier" style="display:none;"><label
                                                        class="col-lg-2 col-form-label">Supplier</label>
                                                    <div class="col-lg-8">
                                                <select class="m-b supplier_id" id="supplier_id" name="supplier_id" >
                                                    <option value="">Select Supplier</option>                                                    
                                                            @foreach ($supplier as $m)                                                             
                                                            <option value="{{$m->id}}">{{$m->name}}</option>
                                                               @endforeach
                                                             </select>
                                                    </div>
                                                </div>
                                              
                                                   <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Reference</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="reference"
                                                            placeholder=""
                                                            class="form-control ">
                                                    </div>
                                                </div>


                                              <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Description</label>
                                                    <div class="col-lg-8">
                                                        <textarea name="description"
                                                            placeholder=""
                                                            class="form-control" rows="2"></textarea>
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

                            <div class="tab-pane fade @if(!empty($id)) active show @endif" id="importExel" role="tabpanel"
                            aria-labelledby="importExel-tab">

                            <div class="card">
                                <div class="card-header">
                                     <form action="{{ route('sample') }}" method="POST" enctype="multipart/form-data">
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
                                                <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                                            
                                                    @csrf
                                                    <div class="form-group mb-4">
                                                        <div class="custom-file text-left">
                                                            <input type="file" name="file" class="form-control" id="customFile" required>
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-primary">Import Journal</button>
                                          
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
          {extend: 'copyHtml5',title: 'JOURNAL ENTRY LIST ', footer: true},
           {extend: 'excelHtml5',title: 'JOURNAL ENTRY LIST' , footer: true},
           {extend: 'csvHtml5',title: 'JOURNAL ENTRY LIST' , footer: true},
            {extend: 'pdfHtml5',title: 'JOURNAL ENTRY LIST', footer: true, customize: function(doc) {
doc.content[1].table.widths = [ '8%', '20%', '32%', '14%', '14%','12%'];
}},
            {extend: 'print',title: 'JOURNAL ENTRY LIST' , footer: true}

                ],
        }
      );
     
    </script>

<script>
$(document).ready(function() {

    $(document).on('change', '.type', function() {
        var id = $(this).val();
  console.log(id);


 if (id == 'Supplier'){
   $("#client").css("display", "none");   
     $("#supplier").css("display", "block");   

}

else if(id == 'Client'){
        $("#client").css("display", "block");   
     $("#supplier").css("display", "none");   
}

else{
  $("#client").css("display", "none");   
     $("#supplier").css("display", "none"); 

}


     

    });



});

</script>



<script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>

@endsection