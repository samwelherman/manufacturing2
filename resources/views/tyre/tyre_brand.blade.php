@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Tire Brand</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Tire Brand
                                    List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Tire Brand</a>
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
                                                    style="width: 28.531px;">#</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Manufacturer</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Brand</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Size</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Price</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Quantity</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Unit</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!@empty($tyre))
                                            @foreach ($tyre as $row)
                                            <tr class="gradeA even" role="row">
                                                <th>{{ $loop->iteration }}</th>
                                                <td>{{$row->manufacturer }}</td>
                                                <td>{{$row->brand}}</td>
                                                <td>{{$row->size}}</td>
                                                <td>{{number_format($row->price,2)}}</td>
                                                <td>{{$row->quantity}}</td>
                                                <td>{{$row->unit}}</td>
                                                
                                                <td>
                                     <div class="form-inline">
                                            <a class="list-icons-item text-primary"
                                                        title="Edit" onclick="return confirm('Are you sure?')"
                                                        href="{{ route('tyre_brand.edit', $row->id)}}"><i
                                                            class="icon-pencil7"></i></a>&nbsp
                                                           
                                                    {!! Form::open(['route' => ['tyre_brand.destroy',$row->id],
                                                    'method' => 'delete']) !!}
                                                    {{ Form::button('<i class="icon-trash"></i>', ['type' => 'submit', 'style' => 'border:none;background: none;', 'class' => 'list-icons-item text-danger', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"]) }}
                                                    {{ Form::close() }}
&nbsp
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
                                        <h5>Edit Tire Brand</h5>
                                        @else
                                        <h5>Add New Tire Brand</h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                     @if(isset($id))
                                                {{ Form::model($id, array('route' => array('tyre_brand.update', $id), 'method' => 'PUT')) }}
                                                @else
                                                {{ Form::open(['route' => 'tyre_brand.store']) }}
                                                @method('POST')
                                                @endif
                                                <div class="form-group row"><label class="col-lg-2 col-form-label">Manufacturer</label>
                                                   <div class="col-lg-10">
                                                           <input type="text" name="manufacturer"
                                                            value="{{ isset($data) ? $data->manufacturer : ''}}"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group row"><label
                                                    class="col-lg-2 col-form-label">Brand</label>

                                                <div class="col-lg-10">
                                                    <input type="text" name="brand"
                                                        value="{{ isset($data) ? $data->brand : ''}}"
                                                        class="form-control">
                                                </div>
                                            </div>

                                               
                                                <div class="form-group row"><label
                                                    class="col-lg-2 col-form-label">Size</label>

                                                <div class="col-lg-10">
                                                    <input type="text" name="size"
                                                        value="{{ isset($data) ? $data->size : ''}}"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group row"><label
                                                class="col-lg-2 col-form-label">Price</label>

                                            <div class="col-lg-10">
                                                <input type="number" name="price"
                                                    value="{{ isset($data) ? $data->price : ''}}"
                                                    class="form-control">
                                            </div>
                                        </div>


                                      
                                           <div class="form-group row"><label
                                                class="col-lg-2 col-form-label">Unit</label>

                                            <div class="col-lg-10">
                                                <input type="text" name="unit"
                                                    value="{{ isset($data) ? $data->unit : ''}}"
                                                    class="form-control">
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
<script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>
@endsection