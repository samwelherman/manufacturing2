@extends('layouts.master')


@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-sm-6 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Products</h4>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link @if (empty($id)) active show @endif" id="home-tab2"
                                        data-toggle="tab" href="#home2" role="tab" aria-controls="home"
                                        aria-selected="true">Product
                                        List</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @if (!empty($id)) active show @endif"
                                        id="profile-tab2" data-toggle="tab" href="#profile2" role="tab"
                                        aria-controls="profile" aria-selected="false">New Product</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link  " id="importExel-tab" data-toggle="tab" href="#importExel"
                                        role="tab" aria-controls="profile" aria-selected="false">Import</a>
                                </li>
                            </ul>
                            <div class="tab-content tab-bordered" id="myTab3Content">
                                <div class="tab-pane fade @if (empty($id)) active show @endif"
                                    id="home2" role="tabpanel" aria-labelledby="home-tab2">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="itemsDatatable">
                                            <thead>
                                                <tr role="row">

                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Browser: activate to sort column ascending"
                                                        style="width: 28.531px;">#</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width: 156.484px;"> Name</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width: 156.484px;">Type</th>
                                                   
                                        
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="CSS grade: activate to sort column ascending"
                                                        style="width: 98.1094px;">Unit</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="CSS grade: activate to sort column ascending"
                                                        style="width: 128.1094px;">Description</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="CSS grade: activate to sort column ascending"
                                                        style="width: 98.1094px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade @if (!empty($id)) active show @endif"
                                    id="profile2" role="tabpanel" aria-labelledby="profile-tab2">

                                    <div class="card">
                                        <div class="card-header">
                                            @if (!empty($id))
                                                <h5>Edit Product</h5>
                                            @else
                                                <h5>Add New Product</h5>
                                            @endif
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-12 ">
                                                    @if (isset($id))
                                                        {{ Form::model($id, ['route' => ['product_items.update', $id], 'method' => 'PUT']) }}
                                                    @else
                                                        {{ Form::open(['route' => 'product_items.store']) }}
                                                        @method('POST')
                                                    @endif

                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Type</label>
                                                        <div class="col-lg-10">
                                                            <select class="form-control m-b" name="type" required>
                                                                <option value="">Select</option>

                                                                <option value="2"
                                                                    {{ isset($data) ? ($data->type == 2 ? 'selected' : '') : '' }}>
                                                                    Manufactured Product</option>

                                                            </select>

                                                        </div>
                                                    </div>

                                                    <div class="form-group row"><label class="col-lg-2 col-form-label">
                                                            Name</label>
                                                        <div class="col-lg-10">
                                                            <input type="text" name="name"
                                                                value="{{ isset($data) ? $data->name : '' }}"
                                                                class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row"><label class="col-lg-2 col-form-label">
                                                            Cost Price</label>

                                                        <div class="col-lg-10">
                                                            <input type="number" name="cost_price"
                                                                value="{{ isset($data) ? $data->cost_price : '' }}"
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-lg-10">
                                                            <input type="hidden" name="sales_price" value="0"
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row"><label class="col-lg-2 col-form-label">
                                                            DN</label>

                                                        <div class="col-lg-10">
                                                            <input type="text" name="dn"
                                                                value="{{ isset($data) ? $data->dn : '' }}"
                                                                class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row"><label class="col-lg-2 col-form-label">
                                                        KG/M</label>

                                                    <div class="col-lg-10">
                                                        <input type="text" name="kg_m"
                                                            value="{{ isset($data) ? $data->kg_m : '' }}"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                    <div class="form-group row"><label class="col-lg-2 col-form-label">
                                                            PN</label>

                                                        <div class="col-lg-10">
                                                            <input type="text" name="pn"
                                                                value="{{ isset($data) ? $data->pn : '' }}"
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row"><label class="col-lg-2 col-form-label">
                                                            Length</label>

                                                        <div class="col-lg-10">
                                                            <input type="text" name="length"
                                                                value="{{ isset($data) ? $data->lengh : '' }}"
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row"><label class="col-lg-2 col-form-label">
                                                            PC/Roller</label>

                                                        <div class="col-lg-10">
                                                            <input type="text" name="pc_roller"
                                                                value="{{ isset($data) ? $data->pc_roller : '' }}"
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Unit</label>

                                                        <div class="col-lg-10">
                                                            <input type="text" name="unit"
                                                                value="{{ isset($data) ? $data->unit : '' }}"
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-form-label col-lg-2">Desription</label>
                                                        <div class="col-lg-10">
                                                            <textarea name="description" class="form-control">{{ isset($data) ? $data->description : '' }}</textarea>
                                                        </div>
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


                                <div class="tab-pane fade" id="importExel" role="tabpanel"
                                    aria-labelledby="importExel-tab">

                                    <div class="card">
                                        <div class="card-header">
                                            <form action="{{ route('item.sample') }}" method="POST"
                                                enctype="multipart/form-data">
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
                                                        <form action="{{ route('item.import') }}" method="POST"
                                                            enctype="multipart/form-data">

                                                            @csrf
                                                            <div class="form-group mb-4">
                                                                <div class="custom-file text-left">
                                                                    <input type="file" name="file"
                                                                        class="form-control" id="customFile" required>
                                                                </div>
                                                            </div>
                                                            <button class="btn btn-primary">Import Items</button>

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
        <div class="modal-dialog">
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function() {
            let urlcontract = "{{ route('product_items.index') }}";
            $('#itemsDatatable').DataTable({
                processing: true,
                serverSide: true,
                searching: true,

                type: 'GET',
                ajax: {
                    url: urlcontract,
                    data: function(d) {
                        d.start_date = $('#date1').val();
                        d.end_date = $('#date2').val();
                        d.from = $('#from').val();
                        d.to = $('#to').val();
                        d.status = $('#status').val();

                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
              
                    
                 

                    {
                        data: 'unit',
                        name: 'unit',
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },


                ]
            })
        });

        function deleteItem(id) {
            var url = '{{ route('items.destroy', ':id') }}';
            url = url.replace(':id', id);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            Swal.fire({
                title: "Delete",
                text: "Do you really want to delete!",
                showCancelButton: !0,
                confirmButtonText: "Yes, delete it!",
                confirmButtonColor: "#3085d6",
                cancelButtonText: "No, cancel!",
                cancelButtonColor: "#aaa",

                reverseButtons: !0,

            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: url,
                        type: "delete",
                        success: function(data) {
                            $('#itemsDatatable').DataTable().ajax.reload();
                            Swal.fire({
                                title: "Deleted",
                                text: "Your data has been deleted",
                                confirmButtonColor: "#3085d6",
                            })
                        }
                    })
                }
            })
        }
    </script>



    <script>
        $('.datatable-basic').DataTable({
            autoWidth: false,
            "columnDefs": [{
                "orderable": false,
                "targets": [3]
            }],
            dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            "language": {
                search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Show:</span> _MENU_',
                paginate: {
                    'first': 'First',
                    'last': 'Last',
                    'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;',
                    'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;'
                }
            },

        });
    </script>
    <script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>



    <script type="text/javascript">
        function model(id) {

            let url = '{{ route('items.show', ':id') }}';
            url = url.replace(':id', id)

            $.ajax({
                type: 'GET',
                url: url,

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
