@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">

            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>School Fees Registraion</h4>
                    </div>
                    <div class="card-body">
                        <!-- Tabs within a box -->
                        <ul class="nav nav-tabs">
                            <li class="nav-item"><a
                                    class="nav-link @if(empty($id)) active show @endif" href="#home2"
                                    data-toggle="tab">School Fees List</a>
                            </li>
                            <li class="nav-item"><a class="nav-link @if(!empty($id)) active show @endif"
                                    href="#profile2" data-toggle="tab">Create New School Fees</a></li>
                        </ul>
                        <div class="tab-content tab-bordered">
                            <!-- ************** general *************-->
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2">

                                <div class="table-responsive">
                                    <table class="table datatable-basic table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th >#</th>
                                                <th>School Fee Name</th>
                                                <th>Total Fee  per Year</th>                                          
                                                <th class="">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           
                                       
                                            @if(!@empty($schools))
                                              @foreach ($schools as $row)
                                                <tr class="gradeA even" role="row">
                                                  <th>{{ $loop->iteration }}</th>
                                                   <td>{{$row->feeType}}</td>
                                                   <td>{{number_format($row->price,2)}}</td>
                                                   <td>
                                                      <div class="form-inline">
                                                
                                                    <a href="#"  class="list-icons-item text-success" title="View"  data-toggle="modal" data-target="#appFormModal"  
                                                    data-id="{{ $row->id }}" data-type="template"   onclick="model({{ $row->id }},'template')">
                                                  <i class="icon-eye"></i></a>                                                             
                                               &nbsp

                                               
                                            <a href="{{ route('school.edit', $row->id)}}" class="list-icons-item text-primary" title="Edit"><i class="icon-pencil7"></i></a> 
                                        &nbsp

                                   
            {!! Form::open(['route' => ['school.destroy',$row->id], 'method' => 'delete']) !!}                                                   
            {{ Form::button('<i class="icon-trash"></i>', ['type' => 'submit','style' => 'border:none;background: none;', 'class' => 'list-icons-item text-danger', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"]) }}
                   {{ Form::close() }}
                          
                             </div></td>      
                                                               
                                      </tr>
                                    @endforeach
                                
                                    @endif
                                
                                   </tbody>
                                       
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade @if(!empty($id)) active show @endif" id="profile2">
                                <div class="card">
                                    <div class="card-header">
                                         @if(empty($id))
                                        <h5>Create School Fees</h5>
                                        @else
                                        <h5>Edit School Fees</h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                  @if(isset($id))
                                                {{ Form::model($id, array('route' => array('school.update', $id), 'method' => 'PUT')) }}
                                                @else
                                                {{ Form::open(['route' => 'school.store','role'=>'form','enctype'=>'multipart/form-data']) }}
                                                @method('POST')
                                                @endif


                                                                <div class="form-group row">
                                                                        <label class="col-lg-2 col-form-label">School Fee Name <span class="required"> *</span></label>  
                                                                       <div class="col-lg-8"> 
                                                                    <input type="text" 
                                                                        name="feeType" value="{{ isset($school) ? $school->feeType : ''}}" placeholder="Enter School Fee Type" 
                                                                        class="form-control" required>
                                                                </div>
                                                                </div>

                                                               




                                   <h4 align="center">Enter Fees</h4>
                                            <hr>

                                             <button type="button" name="add" class="btn btn-success btn-xs tadd"><i class="fas fa-plus"> Add Fee</i></button><br>
                        
                                              <br>
                                            <div class="table-responsive">
                                           <table class="table table-bordered" id="fee">
                                                     <thead>
              <tr>
                <th>Type <span class="required"> *</span></th>
                <th>Amount <span class="required"> *</span></th>                
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
                                    

</tbody>
<tfoot>
@if(!empty($id))
   @if(!@empty($type))
    @foreach ($type as $t)
<?php
$group=App\Models\AccountCodes::where('account_group','School')->where('added_by',auth()->user()->added_by)->get();
?>
 <tr class="line_items">
<td> <select name="type[]" class="form-control m-b type " required>
             <option value="">Select Type</option>
                @foreach ($group as $grp)                                                             
               <option value="{{$grp->id}}" @if(isset($t))@if($t->type == $grp->id) selected @endif @endif >{{$grp->account_name}}</option>
                  @endforeach
                     </select></td>
<td> <input type="number" data-parsley-type="number"  name="amount[]" value="{{ isset($t) ? $t->amount : ''}}"   class="form-control" required></td>
<input type="hidden" data-parsley-type="number"  name="total_amount[]"   class="form-control"  value="{{ isset($t) ? $t->amount : ''}}" jAutoCalc="{amount} * 1" required>
 <input type="hidden" name="type_id[]"  class="form-control name_list"  value= "{{ isset($t) ? $t->id : ''}}" />  
<td><button type="button" name="remove" class="btn btn-danger btn-xs trem" value= "{{ isset($t) ? $t->id : ''}}"><i class="icon-trash"></i></button></td>
</tr>

@endforeach
 @endif
 @endif

 <tr class="line_items">
                                                            
                                                            <td><span class="bold">Total </span>: </td>
                                                            <td><input type="text" name="price"
                                                                    class="form-control item_total" 
                                                                     required
                                                                    jAutoCalc="SUM({total_amount})" readonly></td>
                                                        </tr>

</tfoot>
          </table>




<br>
 
                                                               <h4 align="center">Enter Classes</h4>
                                            <hr>

                                             <button type="button" name="add" class="btn btn-success btn-xs add"><i class="fas fa-plus"> Add Class</i></button><br>
                        
                                              <br>
                                            <div class="table-responsive">
                                           <table class="table table-bordered" id="cart">
                                                     <thead>
              <tr>
                <th>School Level <span class="required"> *</span></th>
                <th>Class <span class="required"> *</span></th>
                
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
                                    

</tbody>
<tfoot>
@if(!empty($id))
   @if(!@empty($items))
    @foreach ($items as $i)
<?php
$class=App\Models\School\SchoolLevel::where('level',$i->level)->get();
?>
 <tr class="line_items">
<td> <select name="level[]" class="form-control m-b level " required>
             <option value="">Select School Level</option>
                @foreach ($level as $lv)                                                             
               <option value="{{$lv->level}}" @if(isset($i))@if($i->level == $lv->level) selected @endif @endif >{{$lv->level}}</option>
                  @endforeach
                     </select></td>
<td><select name="class[]" class="form-control m-b class " id="class" required>
         <option value="">Select Class </option>
            @foreach ($class as $c)                                                             
            <option value="{{$c->id}}" @if(isset($i))@if($i->class == $c->class) selected @endif @endif >{{$c->class}}</option>
                @endforeach
               </select></td>

 <input type="hidden" name="details[]"  class="form-control name_list"  value= "{{ isset($i) ? $i->id : ''}}" />  
<td><button type="button" name="remove" class="btn btn-danger btn-xs rem" value= "{{ isset($i) ? $i->id : ''}}"><i class="icon-trash"></i></button></td>
</tr>

@endforeach
 @endif
 @endif


</tfoot>
          </table>


	
                                                <br>


                                                               <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                        @if(!@empty($id))      
                                                                                                                                                          
                                                <a href="{{ route('school.index')}}" class="btn btn-sm btn-danger float-right m-t-n-xs" >Cancel</a> 
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs" type="submit">Update</button>                                                 
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
                {"orderable": false, "targets": [1]}
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

<script type="text/javascript">
    function model(id, type) {

        let url = '{{ route("school.show", ":id") }}';
        url = url.replace(':id', id)

        $.ajax({
            type: 'GET',
            url: url,
            data: {
                'type': type,
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

    $(document).on('change', '.level', function() {
        var id = $(this).val();
         var sub_category_id = $(this).data('sub_category_id');
        $.ajax({
            url: '{{url("school/findLevel")}}',
            type: "GET",
            data: {
                id: id
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                $('.class'+sub_category_id).empty();
                $('.class'+sub_category_id).append('<option value="">Select Class</option>');
                $.each(response,function(key, value)
                {
                 
                   $('.class'+sub_category_id).append('<option value=' + value.id+ '>' + value.class + '</option>');
                   
                });                      
               
            }

        });

    });

});
</script>

<script type="text/javascript">
		
		  $(document).ready(function(){
      var count = 0;


	$('.add').on("click", function(e) {

        count++;
        var html = '';
html += '<tr class="line_items">';
html += '<td><select name="level[]" class="form-control m-b level" required  data-sub_category_id="'+count+'"><option value="">Select School Level</option>   @foreach ($level as $lv)<option value="{{ $lv->level}}">{{$lv->level}}</option>@endforeach</select></td>';
html += '<td><select name="class[]" class="form-control m-b class'+count+'" required > <option value="">Select Class </option></select></td>';
        html += '<td><button type="button" name="remove" class="btn btn-danger btn-xs remove"><i class="icon-trash"></i></button></td>';

        $('#cart > tbody').append(html);

/*
             * Multiple drop down select
             */
            $('.m-b').select2({
                            });

      });



  $(document).on('click', '.remove', function(){
        $(this).closest('tr').remove();
      });
      

 $(document).on('click', '.rem', function(){  
      var btn_value = $(this).attr("value");   
               $(this).closest('tr').remove();  
            $('#cart >tfoot').append('<input type="hidden" name="removed_id[]"  class="form-control name_list" value="'+btn_value+'"/>');  
       
           });  

		});
		


	</script>



<script type="text/javascript">
		
		  $(document).ready(function(){
      var count = 0;

  function autoCalcSetup() {
        $('table#fee').jAutoCalc('destroy');
        $('table#fee tr.line_items').jAutoCalc({
            keyEventsFire: true,
            decimalPlaces: 2,
            emptyAsZero: true
        });
        $('table#fee').jAutoCalc({
            decimalPlaces: 2
        });
    }
    autoCalcSetup();


	$('.tadd').on("click", function(e) {

        count++;
        var html = '';
html += '<tr class="line_items">';
html += '<td><select  name="type[]" class="form-control m-b type " required  data-sub_category_id="'+count+'"><option value="">Select School Level</option>   @foreach ($group as $grp) <option value="{{$grp->id}}">{{$grp->account_name}}</option>@endforeach</select></td>';
html += '<td><input type="number" data-parsley-type="number"  name="amount[]"   class="form-control" required></td>';
html += '<input type="hidden" data-parsley-type="number"  name="total_amount[]"   class="form-control" jAutoCalc="{amount} * 1" required>';
        html += '<td><button type="button" name="remove" class="btn btn-danger btn-xs tremove"><i class="icon-trash"></i></button></td>';

        $('#fee > tbody').append(html);
 autoCalcSetup();

/*
             * Multiple drop down select
             */
            $('.m-b').select2({
                            });

      });



  $(document).on('click', '.tremove', function(){
        $(this).closest('tr').remove();
         autoCalcSetup();
      });
      

 $(document).on('click', '.trem', function(){  
      var btn_value = $(this).attr("value");   
               $(this).closest('tr').remove();  
            $('#fee >tfoot').append('<input type="hidden" name="tremoved_id[]"  class="form-control name_list" value="'+btn_value+'"/>');  
        autoCalcSetup();
           });  

		});
		


	</script>



@endsection