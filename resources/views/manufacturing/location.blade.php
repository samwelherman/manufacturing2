@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Location</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Location
                                    List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Location</a>
                            </li>

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr role="row">

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Browser: activate to sort column ascending"
                                                    style="width: 208.531px;">#</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Name</th>
                                                   <!-- <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Store Manager</th> -->
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Store Type</th>
                                               
                                               
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!@empty($location))
                                            @foreach ($location as $row)
                                            <tr class="gradeA even" role="row">
                                                <th>{{ $loop->iteration }}</th>
                                                <td>{{$row->name }}</td>
                                               <!-- <td>{{$row->manager }}</td> -->
                                                <td>
                                                @if($row->store_type == 1)
                                                <p>Work Centre</p>
                                                @elseif($row->store_type == 2)
                                                 <p>Finished Product</p>
                                                 @else
                                                 <p>Inventory Store</p>
                                                 @endif
                                                </td>
                                                
                                                <td>
                                                <div class="form-inline">
                                                    <a class="btn btn-xs btn-outline-info text-uppercase px-2 rounded"
                                                        href="{{ route("manufacturing_location.edit", $row->id)}}">
                                                        <i class="icon-pencil7"></i>
                                                    </a>
                                                   

                                                    {!! Form::open(['route' => ['manufacturing_location.destroy',$row->id],
                                                    'method' => 'delete']) !!}
                                                    {{ Form::button('<i class="icon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-xs btn-outline-danger text-uppercase px-2 rounded demo4', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"]) }}
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
                            <div class="tab-pane fade @if(!empty($id)) active show @endif" id="profile2" role="tabpanel"
                                aria-labelledby="profile-tab2">

                                <div class="card">
                                    <div class="card-header">
                                        @if(!empty($id))
                                        <h5>Edit Location</h5>
                                        @else
                                        <h5>Add New Location</h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                     @if(isset($id))
                                                {{ Form::model($id, array('route' => array('manufacturing_location2.update', $id), 'method' => 'PUT')) }}
                                                @else
                                                {{ Form::open(['route' => 'manufacturing_location.store']) }}
                                                @method('POST')
                                                @endif
                                                <div class="form-group row"><label class="col-lg-2 col-form-label">Name</label>
                                                   <div class="col-lg-10">
                                                           <input type="text" name="name"
                                                            value="{{ isset($data) ? $data->name : ''}}"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                  <!--   <div class="form-group row"><label class="col-lg-2 col-form-label">Manager Name</label>
                                                   <div class="col-lg-10">
                                                           <input type="text" name="manager"
                                                            value="{{ isset($data) ? $data->manager : ''}}"
                                                            class="form-control">
                                                    </div>
                                                </div> -->
                                                
                                                <div class="form-group row"><label
                                                    class="col-lg-2 col-form-label">Quantity</label>

                                                <div class="col-lg-10">
                                                    <input type="number" name="quantity"
                                                        value="{{ isset($data) ? $data->quantity : ''}}"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            
                                                     <div class="form-group row"><label class="col-lg-2 col-form-label">Type</label>
                                                   <div class="col-lg-10">
                                                   <select class="form-control" name="store_type">
                                                   <option value="1" {{ isset($data) ? ($data->store_type == 1 ? "selected":'') : ''}}>Work Centre</option>
                                                   <option value="2" {{ isset($data) ? ($data->store_type == 2 ? "selected":'') : ''}}>Finished Products</option>
                                                   <option value="3" {{ isset($data) ? ($data->store_type == 3 ? "selected":'') : ''}}>Inventory Store</option>
                                                   </select>
            
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