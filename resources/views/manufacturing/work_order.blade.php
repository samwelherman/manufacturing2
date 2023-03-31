@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Production Order</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Production Order
                                    List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Production Order</a>
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
                                                    style="width: 126.484px;">Reference No</th>
                                                  
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Expected Date</th>
                                               
                                                     
                                                 <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Client</th>
                                                  
                                                    
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Status</th> 
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 128.1094px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!@empty($work_orders))
                                            @foreach ($work_orders as $row)
                                            <tr class="gradeA even" role="row">
                                                <th>{{ $loop->iteration }}</th>
                                                <td>{{$row->reference_no }}</td>
                                                 
                                                
                                                   <td>{{$row->expected_date}}</td>
                                                
                                                    
                                                <td>{{$row->client->name}}</td>
                                                 @php
                                                      $inv_store = App\Models\Location::find($row->location_id);
                                                 @endphp
                                                 
                                                 
                                                
                                                <td>
                                                    @if($row->status == 0)
                                                    <div class="badge badge-danger badge-shadow">Not Approved</div>
                                                    @elseif($row->status == 1)
                                                    <div class="badge badge-warning badge-shadow">Approved</div>
                                                    @elseif($row->status == 2)
                                                    <div class="badge badge-info badge-shadow">Released</div>
                                                    @elseif($row->status == 3)
                                                    <span class="badge badge-success badge-shadow">Produced</span>

                                                    @endif
                                                </td>
                                                <td>
                                                <div class="form-inline">
                                                @if($row->status == 0)
                                                
                                                    <a class="list-icons-item text-primary"
                                                        href="{{ route("work_order.edit", $row->id)}}">
                                                        <i class="icon-pencil7"></i>
                                                    </a>
                                                   

                                                    {!! Form::open(['route' => ['work_order.destroy',$row->id],
                                                    'method' => 'delete']) !!}
                                                    {{ Form::button('<i class="icon-trash"></i>', ['type' => 'submit', 'style' => 'border:none;background: none;', 'class' => 'list-icons-item text-danger', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"]) }}
                                                    {{ Form::close() }}
                                                    @endif

                                                    
                                                    <div class="dropdown">
							                		<a href="#" class="list-icons-item dropdown-toggle text-teal" data-toggle="dropdown"><i class="icon-cog6"></i></a>

													<div class="dropdown-menu">

                                                                    @if($row->status == 0)
                                                            <li> <a class="nav-link" id="profile-tab2"
                                                                    href="{{ route('work_order.approve',$row->id)}}"
                                                                    role="tab"
                                                                    aria-selected="false">Approve Production Order</a>
                                                            </li>
                                                               @elseif($row->status == 1)
                                                                  <li> <a class="nav-link" id="profile-tab2"
                                                                        href="{{ route('work_order.release',$row->id)}}"
                                                                        role="tab"
                                                                        aria-selected="false">Release Production Order</a>
                                                                </li>

                                                                    @elseif($row->status == 2)
                                                                     <li><a class="nav-link" href=""  data-toggle="modal" href=""  value="{{ $row->id}}" data-type="produce" data-target="#appFormModal"  onclick="model({{ $row->id 
                                                                     }},'produce')">Produce</a>
                                                                </li>

                                                                  <li> <a class="nav-link" id="profile-tab2"
                                                                        href="{{ route('work_order.finish',$row->id)}}"
                                                                        role="tab"
                                                                        aria-selected="false">Finish Production</a>
                                                                </li>
                                                                   @elseif($row->status == 3)
                                                                 <li><a class="nav-link" href=""  data-toggle="modal" href=""  value="{{ $row->id}}" data-type="overhead" data-target="#appFormModal"  onclick="model({{ $row->id 
                                                                     }},'overhead')">Overhead Cost</a>
                                                                </li>

                                                                       @endif
													</div>
					                			</div>
                                                    
                                                    
                                                    
                                                
                                                    
                                                  

        					                			
        					                			
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
                                        <h5>Edit Production Order</h5>
                                        @else
                                        <h5>Add New Production Order</h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                     @if(isset($id))
                                                {{ Form::model($id, array('route' => array('work_order.update', $id), 'method' => 'PUT')) }}
                                                @else
                                                {{ Form::open(['route' => 'work_order.store']) }}
                                                @method('POST')
                                                @endif
                                                

                                                <input type="hidden" name="type"
                                                                class="form-control"
                                                                value="Manufacturing"
                                                                required />
                                                                
                                                <div class="form-group row"><label
                                                    class="col-lg-2 col-form-label">Length</label>

                                                <div class="col-lg-10">
                                                    <input type="number" step="0.1" name="quantity"
                                                        value="{{ isset($data) ? $data->quantity : ''}}"
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
                                                <label class="col-lg-2 col-form-label">Client</label>
                                                   <div class="col-lg-10">
                                                   <select class="form-control m-b" name="user_id" required
                                                                id="user_id">
                                                                <option value="">Select Client</option>
                                                                @if(!empty($client))
                                                                @foreach($client as $row)

                                                                <option @if(isset($data))
                                                                    {{  $data->responsible_id == $row->id  ? 'selected' : ''}}
                                                                    @endif value="{{ $row->id}}">{{$row->name}}</option>

                                                                @endforeach
                                                                @endif

                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Description</label>

                                                    <div class="col-lg-10">
                                                        <input type="text" name="description"
                                                            value="{{ isset($data) ? $data->description : ''}}"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                
                                                
                                              <!--  <div class="form-group row">
                                                <label class="col-lg-2 col-form-label">Created Date</label>
                                                  <div class="col-lg-10">
                                                        <input type="date" name="created_date"
                                                            value="{{ isset($data) ? $data->created_date : ''}}"
                                                            class="form-control">
                                                    </div>
                                                </div>-->
                                                
                                                
                                                <div class="form-group row">
                                                <label class="col-lg-2 col-form-label">Expected Date</label>
                                                  <div class="col-lg-10">
                                                        <input type="date" name="expected_date"
                                                            value="{{ isset($data) ? $data->expected_date : date('Y-m-d')}}"
                                                            class="form-control">
                                                    </div>

                                                    
                                                </div>

                                                <input type="hidden" name="location_id" value="1">
                                                <input type="hidden" name="work_center" value="2">
                                                <input type="hidden" name="finished_store" value="3">
                                                
                                                <br>
                                                <h4 align="center">Enter Products To Be Produced</h4>
                                                <hr>

                                                <hr>
                                                <button type="button" name="add" class="btn btn-success btn-xs add"><i
                                                        class="fas fa-plus"> Add</i></button><br>
                                                <br>
                                                <div class="table-responsive">
                                                <table class="table table-bordered" id="cart">
                                                    <thead>
                                                        <tr>
                                                            <th>Item Name</th>
                                                            <th>Quantity</th>
                                                            <th>Note</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>


                                                    </tbody>
                                                    <tfoot>
                                                        @if(!empty($id))
                                                        @if(!empty($items))
                                                        @foreach ($items as $i)
                                                        <tr class="line_items">
                                                            <td><select name="item_name[]"
                                                                    class="form-control m-b item_name" required
                                                                    data-sub_category_id={{$i->order_no}}>
                                                                    <option value="">Select Item</option>@foreach($name
                                                                    as $n) <option value="{{ $n->id}}"
                                                                        @if(isset($i))@if($n->id == $i->item_name)
                                                                        selected @endif @endif >{{$n->name}}</option>
                                                                    @endforeach
                                                                </select></td>
                                                            <td><input type="numeric" name="quantity[]"
                                                                    class="form-control item_quantity{{$i->id}}"
                                                                    placeholder="quantity" id="quantity"
                                                                    value="{{ isset($i) ? $i->quantity : ''}}"
                                                                    required /></td>
                                                            
                                                            <td><input type="text" name="unit[]"
                                                                    class="form-control item_unit{{$i->order_no}}"
                                                                    placeholder="unit" required
                                                                    value="{{ isset($i) ? $i->unit : ''}}" />
                                                        </td>
                                                      
                                                            <input type="hidden" name="items_id[]"
                                                                class="form-control name_list"
                                                                value="{{ isset($i) ? $i->id : ''}}" />
                                                                
                                                            <input type="hidden" name="saved_items_id[]"
                                                                class="form-control item_saved{{$i->order_no}}"
                                                                value="{{ isset($i) ? $i->id : ''}}"
                                                                required />    
                                                            <td><button type="button" name="remove"
                                                                    class="btn btn-danger btn-xs rem"
                                                                    value="{{ isset($i) ? $i->id : ''}}"><i
                                                                        class="fas fa-trash"></i></button></td>
                                                        </tr>

                                                        @endforeach
                                                        @endif
                                                        @endif

                                                    </tfoot>
                                                </table>
                                           
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
                {"orderable": false, "targets": [3]}
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
$(document).ready(function() {

    $(document).on('change', '.billProduct', function() {
        var id = $(this).val();
        $.ajax({
            url: '{{url("manufacturing/findbillProduct")}}',
            type: "GET",
            data: {
                id: id
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                $("#class").empty();
                $("#class").append('<option value="">Select Product</option>');
                $.each(response,function(key, value)
                {
                 
                    $("#class").append('<option value=' + value.id+ '>' + value.class + '</option>');
                   
                });                      
               
            }

        });

    });

});
</script>

<script type="text/javascript">
    function model(id,type) {

$.ajax({
    type: 'GET',
     url: '{{url("manufacturing/workModal")}}',
    data: {
        'id': id,
        'type':type,
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
    <script>
        $(document).ready(function() {
        
            $(document).on('click', '.remove', function() {
                $(this).closest('tr').remove();
            });
        
            $(document).on('change', '.item_name', function() {
                var id = $(this).val();
                var sub_category_id = $(this).data('sub_category_id');
                $.ajax({
                    url: '{{url("findInvPrice")}}',
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
                    '"><option value="">Select Item</option>@foreach($name as $n) <option value="{{ $n->id}}">{{$n->reference_no}} - {{ $n->item->name}}</option>@endforeach</select></td>';
                html +=
                    '<td><input type="numeric" name="quantity[]" class="form-control item_quantity" data-category_id="' +
                    count + '"placeholder ="quantity" id ="quantity" required /></td>';
              
                html += '<td><input type="text" name="unit[]" class="form-control item_unit' + count +
                    '" placeholder ="Note" required /></td>';
                html +=
                    '<td><button type="button" name="remove" class="btn btn-danger btn-xs remove"><i class="fas fa-trash"></i></button></td>';
        
                $('tbody').append(html);
              $('.m-b').select2({
                                    });
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
@endsection