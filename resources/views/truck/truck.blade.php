@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Truck</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Truck
                                    List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Truck</a>
                            </li>
                          <li class="nav-item">
                                <a class="nav-link  " id="importExel-tab"
                                    data-toggle="tab" href="#importExel" role="tab" aria-controls="profile"
                                    aria-selected="false">Import Truck Stickers</a>
                            </li>
                     <li class="nav-item">
                                <a class="nav-link  " id="import-tab"
                                    data-toggle="tab" href="#import" role="tab" aria-controls="profile"
                                    aria-selected="false">Import Truck Insurance</a>
                            </li>
                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="table-responsive">
                                    <table class="table datatable-basic table-striped">
                                        <thead>
                                            <tr role="row">

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Browser: activate to sort column ascending"
                                                    style="width: 30.531px;">#</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 98.484px;">Truck Name</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Registration No</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Truck Type</th>
                                                 <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Ownership</th>
                                              
                                                 
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Capacity</th>
                                                 
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 170.1094px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!@empty($truck))
                                            @foreach ($truck as $row)
                                            <tr class="gradeA even" role="row">
                                                <th>{{ $loop->iteration }}</th>
                                                <td>{{$row->truck_name }}</td>
                                                <td>{{$row->reg_no}}</td>
                                                <td>{{$row->truck_type}}</td>
                                        <td>
                                             @if($row->type == 'owned')
                                               Owned by Company
                                              @else
                                               Third Party Company
                                         @endif
                                                
                                                  
                                                <td>{{$row->capacity}} KG </td>
                                               
                                                <td>
                                               <div class="form-inline">
                                                    <a class="list-icons-item text-success"
                                                    href="{{ route('truck.insurance', $row->id)}}">
                                                    <i class="icon-eye"></i>
                                                </a>&nbsp&nbsp
                                                    <a class="list-icons-item text-primary"
                                                        href="{{ route("truck.edit", $row->id)}}">
                                                        <i class="icon-pencil7"></i>
                                                    </a>

                                                     @if($row->disabled == 0)
                                                     <a  class="nav-link" style="color:red;font-weight:bold;" title="Disable" onclick="return confirm('Are you sure? you want to disable the truck')"  href="{{ route('truck.disable', $row->id)}}">Disable the Truck</a>
                                              @endif
                                                    </div>
                                                </td>
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
                                        @if(!empty($id))
                                        <h5>Edit Truck</h5>
                                        @else
                                        <h5>Add New Truck</h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                @if(isset($id))
                                                {{ Form::model($id, array('route' => array('truck.update', $id), 'method' => 'PUT',"enctype"=>"multipart/form-data")) }}
                                                @else
                                                {!! Form::open(array('route' => 'truck.store',"enctype"=>"multipart/form-data")) !!}
                                                @method('POST')
                                                @endif

                                                <div class="form-group row"><label class="col-lg-2 col-form-label">Truck Name</label>
                                                   <div class="col-lg-10">
                                                           <input type="text" name="truck_name"
                                                            value="{{ isset($data) ? $data->truck_name : ''}}"
                                                            class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row"><label class="col-lg-2 col-form-label">Registration No</label>
                                                    <div class="col-lg-10">
                                                            <input type="text" name="reg_no"
                                                             value="{{ isset($data) ? $data->reg_no : ''}}"
                                                             class="form-control" required>
                                                     </div>
                                                 </div>
                                                 <div class="form-group row"><label
                                                    class="col-lg-2 col-form-label">Location</label>

                                                <div class="col-lg-10">
                                                   <select class="form-control m-b" style="width: 100%" name="location" required>
                                                       <option value="">Select </option>
                                                        @if(!empty($region))
                                                                @foreach($region as $row)

                                                                <option @if(isset($data))
                                                                    {{  $data->location== $row->id ? 'selected' : ''}}
                                                                    @endif value="{{ $row->id}}">{{$row->name}} </option>

                                                                @endforeach
                                                                @endif
                                                 
                                               </select>
                                                    
                                                </div>
                                            </div>
                                            <div class="form-group row"><label
                                                class="col-lg-2 col-form-label">Truck Type</label>

                                            <div class="col-lg-10">
                                               <select class="form-control m-b" style="width: 100%" name="truck_type" required>
                                                   <option value="">Select Truck Type</option>
                                               <option @if(isset($data))
                                                   {{$data->truck_type == 'Trailer'  ? 'selected' : ''}}
                                                   @endif value="Trailer">Trailer</option>
                                                   <option @if(isset($data))
                                                   {{$data->truck_type == 'Horse'  ? 'selected' : ''}}
                                                   @endif value="Horse">Horse</option>
                                                   <option @if(isset($data))
                                                   {{$data->truck_type== 'Vehicle'  ? 'selected' : ''}}
                                                   @endif value="Vehicle">Vehicle</option>
                                           </select>
                                                
                                            </div>
                                        </div>
                                              <div class="form-group row"><label
                                                class="col-lg-2 col-form-label"> Ownership</label>

                                            <div class="col-lg-10">
                                               <select class="form-control m-b" style="width: 100%" name="type" required>
                                                   <option value="">Select</option>
                                               <option @if(isset($data))
                                                   {{$data->type == 'owned'  ? 'selected' : ''}}
                                                   @endif value="owned">Owned by Company</option>
                                                   <option @if(isset($data))
                                                   {{$data->type == 'non_owned'  ? 'selected' : ''}}
                                                   @endif value="non_owned">Third Party Company</option>
                                                 </select>
                                                
                                            </div>
                                        </div>
                                                <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Truck Capacity (KG)</label>

                                                    <div class="col-lg-10">
                                                        <input type="number" name="capacity" step="0.01"
                                                            value="{{ isset($data) ? $data->capacity : ''}}"
                                                            class="form-control" required>
                                                    </div>
                                                </div>
                                                   <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Fuel</label>

                                                    <div class="col-lg-10">
                                                        <input type="text" name="fuel"
                                                            value="{{ isset($data) ? $data->fuel : ''}}"
                                                            class="form-control" required>
                                                    </div>
                                                </div>
                                                
                                                  <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">No of tyres in Diff Position</label>

                                                    <div class="col-lg-10">
                                                        <input type="text" name="total_diff"
                                                            value="{{ isset($tyre) ? $tyre->total_diff : ''}}"
                                                            class="form-control"   required>
                                                    </div>
                                                </div>
                                                
                            <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">No of tyres in Rear Position</label>

                                                    <div class="col-lg-10">
                                                        <input type="text" name="total_rear"
                                                            value="{{ isset($tyre) ? $tyre->total_rear : ''}}"
                                                            class="form-control"   required>
                                                    </div>
                                                </div>
                                         
                                              <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">No of tyres in Trailer Position</label>

                                                    <div class="col-lg-10">
                                                        <input type="text" name="total_trailer"
                                                            value="{{ isset($tyre) ? $tyre->total_trailer : ''}}"
                                                            class="form-control"   required>
                                                    </div>
                                                </div>

                                                    <div class="form-group row">
 
                                                     
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

   <div class="tab-pane fade" id="importExel" role="tabpanel"
                            aria-labelledby="importExel-tab">

                            <div class="card">
                                <div class="card-header">
                                     <form action="{{ route('sticker.sample') }}" method="POST" enctype="multipart/form-data">
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
                                                <form action="{{ route('sticker.import') }}" method="POST" enctype="multipart/form-data">
                                            
                                                    @csrf
                                                    <div class="form-group mb-4">
                                                        <div class="custom-file text-left">
                                                            <input type="file" name="file" class="form-control" id="customFile" required>
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-primary">Import Truck Sticker</button>
                                          
                                        </form>
                                       
                                    </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>



  <div class="tab-pane fade" id="import" role="tabpanel"
                            aria-labelledby="import-tab">

                            <div class="card">
                                <div class="card-header">
                                     <form action="{{ route('insurance.sample') }}" method="POST" enctype="multipart/form-data">
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
                                                <form action="{{ route('insurance.import') }}" method="POST" enctype="multipart/form-data">
                                            
                                                    @csrf
                                                    <div class="form-group mb-4">
                                                        <div class="custom-file text-left">
                                                            <input type="file" name="file" class="form-control" id="customFile" required>
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-primary">Import Truck Insurance</button>
                                          
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
<script>
    var loadBigFile=function(event){
      var output=document.getElementById('big_output');
      output.src=URL.createObjectURL(event.target.files[0]);
    };
  </script>
<script>
$(document).ready(function() {
    $('.dataTables-example').DataTable({
        pageLength: 25,
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: [{
                extend: 'copy'
            },
            {
                extend: 'csv'
            },
            {
                extend: 'excel',
                title: 'ExampleFile'
            },
            {
                extend: 'pdf',
                title: 'ExampleFile'
            },

            {
                extend: 'print',
                customize: function(win) {
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            }
        ]

    });

});


$('.demo4').click(function() {
    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this imaginary file!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false
    }, function() {
        swal("Deleted!", "Your imaginary file has been deleted.", "success");
    });
});
</script>
<script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>
@endsection