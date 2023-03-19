@extends('layouts.master')

@section('content')

<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Truck Details For {{$truck->truck_name}} - {{$truck->reg_no}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-2">
                                <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active "  id="#tab1" 
                                        href="{{ route('truck.insurance', $truck->id)}}"  aria-controls="home"
                                            aria-selected="true">Insurance</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="#tab2" 
                                            href="{{ route('truck.sticker', $truck->id)}}"  aria-controls="profile"
                                            aria-selected="false">LATRA Sticker</a>
                                    </li>
                           <li class="nav-item">
                                        <a class="nav-link" id="#tab2" 
                                            href="{{ route('truck.permit', $truck->id)}}"  aria-controls="profile"
                                            aria-selected="false">Road Permit</a>
                                    </li>
                                <li class="nav-item">
                                        <a class="nav-link" id="#tab2" 
                                            href="{{ route('truck.comesa', $truck->id)}}"  aria-controls="profile"
                                            aria-selected="false">COMESA</a>
                                    </li>
                                <li class="nav-item">
                                        <a class="nav-link" id="#tab2" 
                                            href="{{ route('truck.carbon', $truck->id)}}"  aria-controls="profile"
                                            aria-selected="false">CARBON</a>
                                    </li>
                               <li class="nav-item">
                                        <a class="nav-link" id="#tab3" 
                                            href="{{ route('truck.fuel', $truck->id)}}"  aria-controls="profile"
                                            aria-selected="false">Fuel Report</a>
                                    </li>

                               <li class="nav-item">
                                        <a class="nav-link" id="#tab4" 
                                            href="{{ route('truck.route', $truck->id)}}"  aria-controls="profile"
                                            aria-selected="false">Routes</a>
                                    </li>
                                   
                                  
                                     


                                </ul>
                            </div>
                            <div class="col-12 col-sm-12 col-md-10">
                                <div class="tab-content no-padding" id="myTab2Content">
                                    <div class="tab-pane fade @if($type =='insurance' || $type == 'edit-insurance') active show  @endif" id="tab1"
                                    role="tabpanel" aria-labelledby="tab1">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>Insurance</h4>
                                        </div>
                                        <div class="card-body">
                                            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link @if($type =='insurance') active show @endif" id="home-tab2"
                                                        data-toggle="tab" href="#home2" role="tab" aria-controls="home"
                                                        aria-selected="true">Insurance List
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link @if($type =='edit-insurance') active show @endif" id="profile-tab2"
                                                        data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                                        aria-selected="false"> New Insurance</a>
                                                </li>
                                
                                            </ul>
                                            <div class="tab-content tab-bordered" id="myTab3Content">
                                                <div class="tab-pane fade @if($type =='insurance') active show @endif" id="home2" role="tabpanel"
                                                    aria-labelledby="home-tab2">
                                                    <div class="table-responsive">
                                                      <table class="table datatable-basic table-striped">
                                                            <thead>
                                                                <tr role="row">
                                
                                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                                    rowspan="1" colspan="1"
                                                                    aria-label="Browser: activate to sort column ascending"
                                                                    style="width: 28.531px;">#</th>
                                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                                        colspan="1" aria-label="Engine version: activate to sort column ascending"
                                                                        style="width: 141.219px;">Broker Name</th>
                                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                                        colspan="1" aria-label="Engine version: activate to sort column ascending"
                                                                        style="width: 141.219px;">Insurance Company</th>
                                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                                        colspan="1" aria-label="Engine version: activate to sort column ascending"
                                                                        style="width: 141.219px;">Cover Type</th>
                                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                                        colspan="1" aria-label="Engine version: activate to sort column ascending"
                                                                        style="width: 141.219px;">Amount</th>
                                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                                        colspan="1" aria-label="Engine version: activate to sort column ascending"
                                                                        style="width: 141.219px;"> Cover Date</th>
                                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                                        colspan="1" aria-label="Engine version: activate to sort column ascending"
                                                                        style="width: 141.219px;"> Expire Date</th>
                                                                    
                                                                    
                                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                                        colspan="1" aria-label="CSS grade: activate to sort column ascending"
                                                                        style="width: 98.1094px;">Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if(!@empty($insurance))
                                                                @foreach ($insurance as $row)
                                                                <tr class="gradeA even" role="row">
                                                                    <th>{{ $loop->iteration }}</th>
                                                                    <td>@if(!empty($row->broker_name)) {{$row->supplier->name}} @endif</td>
                                                                    <td>{{$row->company}}</td>
                                                                    <td>{{$row->cover}}</td>
                                                                    <td>{{number_format($row->value,2)}}</td>
                                                                    <td>{{Carbon\Carbon::parse($row->cover_date)->format('M d, Y')}}</td>
                                                                    <td>{{Carbon\Carbon::parse($row->expire_date)->format('M d, Y')}}</td>
                                
                                
                                                                    <td>
                                                                          <div class="form-inline">
                                                                        <a  class="list-icons-item text-primary"
                                                                        href="{{ route("truckinsurance.edit", $row->id)}}">
                                                                     <i class="icon-pencil7"></i>
                                                    </a>&nbsp
                                                                 
                                
                                                                    {!! Form::open(['route' => ['truckinsurance.destroy',$row->id],
                                                                    'method' => 'delete']) !!}
                                                                     {{ Form::button('<i class="icon-trash"></i>', ['type' => 'submit', 'style' => 'border:none;background: none;', 'class' => 'list-icons-item text-danger', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"]) }}
                                                    {{ Form::close() }}
           </div>     
                                
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                
                                                                @endif
                                
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade @if($type =='edit-insurance') active show @endif" id="profile2"
                                                    role="tabpanel" aria-labelledby="profile-tab2">
                                
                                                    <div class="card">
                                                        <div class="card-header">
                                                            @if($type =='edit-insurance')
                                                            <h5>Edit Insurance</h5>
                                                            @else
                                                            <h5>New Insurance</h5>
                                                            @endif
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-sm-12 ">
                                                                    @if($type =='edit-insurance')
                                                                    {{ Form::model($id, array('route' => array('truckinsurance.update', $id), 'method' => 'PUT',"enctype"=>"multipart/form-data")) }}
                                                                    @else
                                                                    {{ Form::open(['route' => 'truckinsurance.store',"enctype"=>"multipart/form-data"]) }}
                                                                    @method('POST')
                                                                    @endif
                                
                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-6">
                                                                            
                                                                            <input type="hidden" name="truck_id" class="form-control" id="type"
                                                                                value="{{$truck->id}}" placeholder="">

                                                                            <label for="inputEmail4">Broker Name</label>
                                                                              <select class="m-b supplier_id" id="supplier_id" name="broker_name" required>
                                                    <option value="">Select Broker</option>                                                    
                                                            @foreach ($client as $m)                                                             
                                                            <option value="{{$m->id}}" @if(isset($data))@if($data->broker_name == $m->id) selected @endif @endif >{{$m->name}}</option>
                                                               @endforeach
                                                             </select>

                                                                             
                                                                        </div>


                                                                        <div class="form-group col-md-6">
                                                           
                                                                             <label for="inputEmail4">Company Name</label>
                                                                             <input type="text" name="company"
                                                                         value="{{ isset($data) ? $data->company : ''}}"
                                                            class="form-control" required>
                                                                        </div>
                                                                        </div>
                                
                                                                        <div class="form-row">
                                                                            <div class="form-group col-md-6">
                                                                                
    
                                                                                <label for="inputEmail4">Cover Type</label>
                                                                                <select class="form-control m-b" name="cover" required>
                                                                                    <option value="">Select Cover Type</option>
                                                                                <option @if(isset($data))
                                                                                    {{$data->cover == 'Third Party'  ? 'selected' : ''}}
                                                                                    @endif value="Third Party">Third Party</option>
                                                                                    <option @if(isset($data))
                                                                                    {{$data->cover == 'Premium'  ? 'selected' : ''}}
                                                                                    @endif value="Premium">Premium</option>
                                                                                    
                                                                            </select>
                                                                            </div>
    
    
                                                                            <div class="form-group col-md-6">
                                                               
                                                                                 <label for="inputEmail4">Amount</label>
                                                                                 <input type="number" name="value"
                                                                             value="{{ isset($data) ? $data->value : ''}}"
                                                                class="form-control" required>
                                                                            </div>
                                                                            </div>
                                                                    
                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-6">
                                
                                                                            <label for="inputEmail4">Cover Date</label>
                                                                            <input type="date" name="cover_date" class="form-control" 
                                                                                value="{{ !empty($data) ? $data->cover_date : ''}}"  
                                                                                required>
                                                                        </div>
                                                                        
                                                                        <div class="form-group col-md-6 col-lg-6">
                                                                            <label for="date">Expire Date</label>
                                                                            <input type="date" name="expire_date" class="form-control"
                                                                                value="{{ !empty($data) ? $data->expire_date : ''}}" 
                                                                                required>
                                
                                                                        </div>
                                         
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-lg-offset-2 col-lg-12">
                                                                            @if($type =='edit-insurance')
                                                                            <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                                                data-toggle="modal" data-target="#myModal" type="submit">Update</button>
                                                                               &nbsp;<a class="btn btn-sm btn-danger float-right m-t-n-xs"
                                                                                  href="{{ route('truck.insurance', $truck->id)}}"> Cancel   </a>
                                                           
                                                     
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
<script src="{{ asset('assets2/js/bootstrap-datepicker.min.js') }}"></script>
<script>
    function myFunction() {
       // alert('hellow')
  //var element = document.getElementById("#tab2");
  //element.classList.add("active");
}
</script>
<script type="text/javascript">
 $(document).ready(function(){
  $("#datepicker,#datepicker2").datepicker({
     format: "yyyy",
     viewMode: "years", 
     minViewMode: "years",
     autoclose:true
  });   
})

 </script>
@endsection