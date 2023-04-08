@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-124 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Good Movement</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Good Movement
                                    List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Good Movement</a>
                            </li>

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="table-responsive">
                                    <table class="table datatable-basic table-striped" id="table-1">
                                        <thead>
                                            <tr role="row">

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Browser: activate to sort column ascending"
                                                    style="width: 208.531px;">#</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Date</th>
                                               
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Item Name</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Quantity</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 141.219px;">Source Location</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Destination Location</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Resposible Person</th>

                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Status</th>
                                                   
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!@empty($movement))
                                            @foreach ($movement as $row)
                                            <tr class="gradeA even" role="row">
                                                <th>{{ $loop->iteration }}</th>
                                                <td>{{Carbon\Carbon::parse($row->date)->format('M d, Y')}}</td>
                                                <td>
                                                    {{ $row->items->name }}
                                                </td>
                                               
                                                <td>{{ $row->quantity }}</td>
                                                <td>
                                                    @php    
                                                    $tr=App\Models\Location::where('id', $row->source_location)->get();   
                                                  @endphp
                                                     @foreach($tr as $t)
                                                     {{$t->name}}
                                                    @endforeach
                                                </td>
                                                    
                                                <td>
                                                   
                                                    @php
                                                         
                                                    $dr=App\Models\Location::where('id', $row->destination_location)->get();   
                                                  @endphp
                                                     @foreach($dr as $d)
                                                     {{$d->name}}
                                                    @endforeach
                                                      
                                                </td>

                                                <td>
                                                    @php    
                                                    $st=App\Models\FieldStaff::where('id', $row->staff)->get();   
                                                  @endphp
                                                     @foreach($st as $s)
                                                    {{$s->name}}
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @if($row->status == 0)
                                                    <div class="badge badge-warning badge-shadow">Not Approved</div>
                                                    @elseif($row->status == 1)
                                                    <div class="badge badge-success badge-shadow">Approved</div>
                                                    @endif
                                                </td>

                                                      <td>
                                                 @if($row->status == 0)
                                                 <div class="form-inline">
                                             <a class="btn btn-xs btn-outline-primary text-uppercase px-2 rounded"
                                                    href="{{ route("good_movement.approve", $row->id)}}" title="Approve" onclick="return confirm('Are you sure?')">
                                                    <i class="icon-check"></i>
                                                </a>
                                                    <a class="btn btn-xs btn-outline-info text-uppercase px-2 rounded"
                                                        href="{{ route("good_movement.edit", $row->id)}}">
                                                        <i class="icon-pencil7"></i>
                                                    </a>
                                                   
                                                    {!! Form::open(['route' => ['good_movement.destroy',$row->id],
                                                    'method' => 'delete']) !!}
                                                    {{ Form::button('<i class="icon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-xs btn-outline-danger text-uppercase px-2 rounded demo4', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"]) }}
                                                    {{ Form::close() }}
                                                    </div>
                                           @endif
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
                                        <h5>Edit Good Movement</h5>
                                        @else
                                        <h5>Add New Good Movement</h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                     @if(isset($id))
                                                {{ Form::model($id, array('route' => array('good_movement.update', $id), 'method' => 'PUT')) }}
                                                @else
                                                {{ Form::open(['route' => 'good_movement.store']) }}
                                                @method('POST')
                                                @endif

                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Date</label>
                                                    <div class="col-lg-4">
                                                        <input type="date" name="date"
                                                            placeholder="0 if does not exist"
                                                            value="{{ isset($data) ? $data->date : ''}}"
                                                            class="form-control" required>
                                                    </div>
                                                    <label class="col-lg-2 col-form-label">Resposible Person</label>
                                                    <div class="col-lg-4">
                                                     <select class="form-control type" name="staff" required
                                                         id="">
                                                 <option value="">Select 
                                                    @if(!empty($staff))
                                                    @foreach($staff as $row)

                                                    <option @if(isset($data))
                                                        {{ $data->staff == $row->id  ? 'selected' : ''}}
                                                        @endif value="{{$row->id}}">{{$row->name}}</option>

                                                    @endforeach
                                                    @endif                                              
 
                                             </select>
                                                   
                                                </div>
                                            </div>

                                                

                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Source Location</label>
                                                    <div class="col-lg-4">
                                                        <select class="form-control" name="source_location" required
                                                                id="supplier_id">
                                                        <option value="">Select Source</option>
                                                        @if(!empty($location))
                                                        @foreach($location as $row)

                                                        <option @if(isset($data))
                                                            {{ $data->source_location == $row->id  ? 'selected' : ''}}
                                                            @endif value="{{$row->id}}">{{$row->name}}</option>

                                                        @endforeach
                                                        @endif

                                                    </select>
                                                    </div>
                                                
                                                    <label
                                                    class="col-lg-2 col-form-label">Destination Location</label>

                                                <div class="col-lg-4">
                                                    <select class="form-control type_id" name="destination_location" required
                                                    id="">
                                                    <option value="">Select Destination</option>
                                                    @if(!empty($location))
                                                    @foreach($location as $row)

                                                    <option @if(isset($data))
                                                        {{ $data->destination_location == $row->id  ? 'selected' : ''}}
                                                        @endif value="{{$row->id}}">{{$row->name}}</option>

                                                    @endforeach
                                                    @endif
                                            </select>
                                                    </div>
                                                </div>
                                          
                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Item Name</label>
                                                    <div class="col-lg-4">

                                                         <select name="item_id"
                                                            class="form-control item_name" required
                                                            >
                                                            <option value="">Select Item</option>@foreach($inventory
                                                            as $n) <option value="{{ $n->id}}"
                                                                @if(isset($data))@if($n->id == $data->item_id)
                                                                selected @endif @endif >{{$n->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <label
                                                    class="col-lg-2 col-form-label">Quantity</label>

                                                <div class="col-lg-4">
                                                    <input type="number" name="quantity"
                                                            class="form-control item_quantity"
                                                            placeholder="quantity" id="quantity"
                                                            value="{{ isset($data) ? $data->quantity : ''}}"
                                                            required />     
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