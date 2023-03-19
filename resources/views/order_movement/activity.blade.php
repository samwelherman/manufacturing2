@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>All Order Activities Performed by Staffs </h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                           
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Order Activity List </a>
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
                                                    style="width: 186.484px;">Staff Name</th>
                                               
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">REF NO - Shipment Name</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 86.484px;">Qty</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Route</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Date</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Activity Performed</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!@empty($activity))
                                            @foreach ($activity as $row)
                                            <tr class="gradeA even" role="row">
                                                @if ($row->module == 'Order')
                                               
                                                @php
                                                 $order=App\Models\orders\Transport_quotation::find($row->module_id);
                                                                                            
                                            @endphp

                                            @else
                                            @php
                                            $pacel=App\Models\CargoLoading::find($row->loading_id); 
                                            $route = App\Models\Route::find($pacel->route_id); 
                                        @endphp
                                        
                                            @endif

                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{$row->user->name}}</td>
                                                
                                              

                                                @if ($row->module == 'Order')
                                                <td>
                                                    @php
                                                    $name=App\Models\Crops_type::where('id',$order->crop_type)->first();
                                                @endphp
                                                    {{$name->crop_name}}</td>  
                                               
                                                @else
                                             
                                                <td>{{$pacel->pacel_number}} - {{$pacel->pacel_name}} </td>
                                                   @endif

                                                   @if ($row->module == 'Order')
                                                   <td> {{$order->quantity}} kgs</td> 
                                                   @else                                               
                                                   <td>{{$pacel->quantity}} </td>
                                                      @endif

                                                    @if ($row->module == 'Order')
                                                      <td> From {{$order->start_location}} to {{$order->end_location}}</td> 
                                                      @else                                               
                                                      <td> From {{$route->from}} to {{$route->to}}</td>
                                                         @endif

                                                <td>{{$row->date}}</td>
                                                <td>{{$row->activity}}</td>
                                            </tr>
                                            @endforeach

                                            @endif

                                        </tbody>
                                    </table>
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