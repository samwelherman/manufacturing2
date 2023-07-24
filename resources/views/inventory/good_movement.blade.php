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
                                    <a class="nav-link @if (empty($id)) active show @endif" id="home-tab2"
                                        data-toggle="tab" href="#home2" role="tab" aria-controls="home"
                                        aria-selected="true">Good Movement
                                        List</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @if (!empty($id)) active show @endif"
                                        id="profile-tab2" data-toggle="tab" href="#profile2" role="tab"
                                        aria-controls="profile" aria-selected="false">New Good Movement</a>
                                </li>

                            </ul>
                            <div class="tab-content tab-bordered" id="myTab3Content">
                                <div class="tab-pane fade @if (empty($id)) active show @endif"
                                    id="home2" role="tabpanel" aria-labelledby="home-tab2">
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
                                                        style="width: 141.219px;">Reference No</th>
                                                  
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
                                                @if (!@empty($movement))
                                                    @foreach ($movement as $row)
                                                        <tr class="gradeA even" role="row">
                                                            <th>{{ $loop->iteration }}</th>
                                                            <td>{{ Carbon\Carbon::parse($row->date)->format('M d, Y') }}
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('good_movement.show',$row->id) }}">{{ $row->reference_no }}</a>
                                                                
                                                            </td>

                                                            <td>
                                                                @php
                                                                    $tr = App\Models\Location::where('id', $row->source_location)->get();
                                                                @endphp
                                                                @foreach ($tr as $t)
                                                                    {{ $t->name }}
                                                                @endforeach
                                                            </td>

                                                            <td>

                                                                @php
                                                                    
                                                                    $dr = App\Models\Location::where('id', $row->destination_location)->get();
                                                                @endphp
                                                                @foreach ($dr as $d)
                                                                    {{ $d->name }}
                                                                @endforeach

                                                            </td>

                                                            <td>
                                                                @php
                                                                    $st = App\Models\FieldStaff::where('id', $row->staff)->get();
                                                                @endphp
                                                                @foreach ($st as $s)
                                                                    {{ $s->name }}
                                                                @endforeach
                                                            </td>
                                                            <td>
                                                                @if ($row->status == 0)
                                                                    <div class="badge badge-warning badge-shadow">Not
                                                                        Approved</div>
                                                                @elseif($row->status == 1)
                                                                    <div class="badge badge-success badge-shadow">Approved
                                                                    </div>
                                                                @endif
                                                            </td>

                                                            <td>
                                                                @if ($row->status == 0)
                                                                    <div class="form-inline">
                                                                        <a class="btn btn-xs btn-outline-primary text-uppercase px-2 rounded"
                                                                            href="{{ route('good_movement.approve', $row->id) }}"
                                                                            title="Approve"
                                                                            onclick="return confirm('Are you sure?')">
                                                                            <i class="icon-check"></i>
                                                                        </a>
                                                                        <a class="btn btn-xs btn-outline-info text-uppercase px-2 rounded"
                                                                            href="{{ route('good_movement.edit', $row->id) }}">
                                                                            <i class="icon-pencil7"></i>
                                                                        </a>

                                                                        {!! Form::open(['route' => ['good_movement.destroy', $row->id], 'method' => 'delete']) !!}
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
                                <div class="tab-pane fade @if (!empty($id)) active show @endif"
                                    id="profile2" role="tabpanel" aria-labelledby="profile-tab2">

                                    <div class="card">
                                        <div class="card-header">
                                            @if (!empty($id))
                                                <h5>Edit Good Movement</h5>
                                            @else
                                                <h5>Add New Good Movement</h5>
                                            @endif
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-12 ">
                                                    @if (isset($id))
                                                        {{ Form::model($id, ['route' => ['good_movement.update', $id], 'method' => 'PUT']) }}
                                                    @else
                                                        {{ Form::open(['route' => 'good_movement.store']) }}
                                                        @method('POST')
                                                    @endif

                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label">Date</label>
                                                        <div class="col-lg-4">
                                                            <input type="date" name="date"
                                                                placeholder="0 if does not exist"
                                                                value="{{ isset($data) ? $data->date : '' }}"
                                                                class="form-control" required>
                                                        </div>
                                                        <label class="col-lg-2 col-form-label">Resposible Person</label>
                                                        <div class="col-lg-4">
                                                            <select class="form-control type" name="staff" required
                                                                id="">
                                                                <option value="">Select
                                                                    @if (!empty($staff))
                                                                        @foreach ($staff as $row)
                                                                <option
                                                                    @if (isset($data)) {{ $data->staff == $row->id ? 'selected' : '' }} @endif
                                                                    value="{{ $row->id }}">{{ $row->name }}
                                                                </option>
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
                                                                @if (!empty($location))
                                                                    @foreach ($location as $row)
                                                                        <option
                                                                            @if (isset($data)) {{ $data->source_location == $row->id ? 'selected' : '' }} @endif
                                                                            value="{{ $row->id }}">
                                                                            {{ $row->name }}</option>
                                                                    @endforeach
                                                                @endif

                                                            </select>
                                                        </div>

                                                        <label class="col-lg-2 col-form-label">Destination Location</label>

                                                        <div class="col-lg-4">
                                                            <select class="form-control type_id"
                                                                name="destination_location" required id="">
                                                                <option value="">Select Destination</option>
                                                                @if (!empty($location))
                                                                    @foreach ($location as $row)
                                                                        <option
                                                                            @if (isset($data)) {{ $data->destination_location == $row->id ? 'selected' : '' }} @endif
                                                                            value="{{ $row->id }}">
                                                                            {{ $row->name }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>

                                                    
                                                    <br>
                                                    <h4 align="center">Enter Materials To Be Moved</h4>
                                                    <hr>

                                                    <hr>
                                                    <button type="button" name="add"
                                                        class="btn btn-success btn-xs add"><i class="fas fa-plus"> Add
                                                            Material</i></button><br>
                                                    <br>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered" id="cart">
                                                            <thead>
                                                                <tr>
                                                                    <th>Item Name</th>
                                                                    <th>Quantity</th>
                                                                    <th>Unit</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>


                                                            </tbody>
                                                            <tfoot>
                                                                @if (!empty($id))
                                                                    @if (!empty($items))
                                                                        @foreach ($items as $i)
                                                                            <tr class="line_items">
                                                                                <td><select name="item_name[]"
                                                                                        class="form-control m-b item_name"
                                                                                        required
                                                                                        data-sub_category_id={{ $i->order_no }}>
                                                                                        <option value="">Select Item
                                                                                        </option>
                                                                                        @foreach ($name as $n)
                                                                                            <option
                                                                                                value="{{ $n->id }}"
                                                                                                @if (isset($i)) @if ($n->id == $i->item_id)
                                                                        selected @endif
                                                                                                @endif
                                                                                                >{{ $n->name }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select></td>
                                                                                <td><input type="numeric"
                                                                                        name="quantity[]"
                                                                                        class="form-control item_quantity{{ $i->id }}"
                                                                                        placeholder="quantity"
                                                                                        id="quantity"
                                                                                        value="{{ isset($i) ? $i->quantity : '' }}"
                                                                                        required /></td>

                                                                                <td><input type="text" name="unit[]"
                                                                                        class="form-control item_unit{{ $i->order_no }}"
                                                                                        placeholder="unit" required
                                                                                        value="{{ isset($i) ? $i->unit : '' }}" />
                                                                                </td>

                                                                                <input type="hidden" name="items_id[]"
                                                                                    class="form-control name_list"
                                                                                    value="{{ isset($i) ? $i->id : '' }}" />

                                                                                <input type="hidden"
                                                                                    name="saved_items_id[]"
                                                                                    class="form-control item_saved{{ $i->order_no }}"
                                                                                    value="{{ isset($i) ? $i->id : '' }}"
                                                                                    required />
                                                                                <td><button type="button" name="remove"
                                                                                        class="btn btn-danger btn-xs rem"
                                                                                        value="{{ isset($i) ? $i->id : '' }}"><i
                                                                                            class="fas fa-trash"></i></button>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    @endif
                                                                @endif

                                                            </tfoot>
                                                        </table>
                                                    </div>


                                                    <div class="form-group row">
                                                        <div class="col-lg-offset-2 col-lg-12">
                                                            @if (!@empty($id))
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
    <script>
        $(document).ready(function() {

            $(document).on('click', '.remove', function() {
                $(this).closest('tr').remove();
            });

            $(document).on('change', '.item_name', function() {
                var id = $(this).val();
                var sub_category_id = $(this).data('sub_category_id');
                $.ajax({
                    url: '{{ url('findInvPrice') }}',
                    type: "GET",
                    data: {
                        id: id
                    },
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
                        $('.item_price' + sub_category_id).val(data[0]["price"]);
                        $(".item_unit" + sub_category_id).val(data[0]["unit"]);

                    }

                });

            });


        });
    </script>



    <script type="text/javascript">
        $(document).ready(function() {


            var count = 0;


            function autoCalcSetup() {
                $('table#cart').jAutoCalc('destroy');
                $('table#cart tr.line_items').jAutoCalc({
                    keyEventsFire: true,
                    decimalPlaces: 2,
                    emptyAsZero: true
                });
                $('table#cart').jAutoCalc({
                    decimalPlaces: 2
                });
            }
            autoCalcSetup();

            $('.add').on("click", function(e) {

                count++;
                var html = '';
                html += '<tr class="line_items">';
                html +=
                    '<td><select name="item_name[]" class="form-control m-b item_name" required  data-sub_category_id="' +
                    count +
                    '"><option value="">Select Item</option>@foreach ($name as $n) <option value="{{ $n->id }}">{{ $n->name }}</option>@endforeach</select></td>';
                html +=
                    '<td><input type="numeric" name="quantity[]" class="form-control item_quantity" data-category_id="' +
                    count + '"placeholder ="quantity" id ="quantity" required /></td>';

                html += '<td><input type="text" name="unit[]" class="form-control item_unit' + count +
                    '" placeholder ="unit" required /></td>';
                html +=
                    '<td><button type="button" name="remove" class="btn btn-danger btn-xs remove"><i class="fas fa-trash"></i></button></td>';

                $('tbody').append(html);
                $('.m-b').select2({});
                autoCalcSetup();
            });

            $(document).on('click', '.remove', function() {
                $(this).closest('tr').remove();
                autoCalcSetup();
            });


            $(document).on('click', '.rem', function() {
                var btn_value = $(this).attr("value");
                $(this).closest('tr').remove();
                $('tfoot').append(
                    '<input type="hidden" name="removed_id[]"  class="form-control name_list" value="' +
                    btn_value + '"/>');
                autoCalcSetup();
            });

        });
    </script>


    <script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>
@endsection
