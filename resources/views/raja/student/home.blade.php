@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">

            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Student Registraion</h4>
                    </div>
                    <div class="card-body">
                        <!-- Tabs within a box -->
                        <ul class="nav nav-tabs">
                            <li class="nav-item"><a
                                    class="nav-link @if(empty($id)) active show @endif" href="#home2"
                                    data-toggle="tab">Students List</a>
                            </li>
                            <li class="nav-item"><a class="nav-link @if(!empty($id)) active show @endif"
                                    href="#profile2" data-toggle="tab">Create New Student</a></li>
                         <li class="nav-item">
                                <a class="nav-link  " id="importExel-tab"
                                    data-toggle="tab" href="#importExel" role="tab" aria-controls="profile"
                                    aria-selected="false">Import New Students</a>
                            </li>
                        </ul>
                        <div class="tab-content tab-bordered">
                            <!-- ************** general *************-->
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2">

                                <div class="table-responsive">
                                    <table class="table datatable-basic table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th >#</th>
                                                <th>Student Name</th>
                                              <th>Student Gender</th>
                                                <th>School Level</th>
                                                <th>Class</th>
                                           <th>Parent Name</th>
                                           <th>Parent Phone</th>
                                                <th>Registration Date</th>
                                           
                                                <th class="">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                       
                                            @if(!@empty($students))
                                              @foreach ($students as $row)
                                                <tr class="gradeA even" role="row">
                                                  <th>{{ $loop->iteration }}</th>
                                                   <td>{{$row->student_name}}</td>
                                                     <td>{{$row->gender}}</td>
                                                   <td>{{$row->level}}</td>
                                                   <td>{{$row->class}}</td>
                                                   <td>{{$row->parent_name}}</td>
                                                   <td>{{$row->parent_phone}}</td>
                                                   <td>{{Carbon\Carbon::parse($row->yearStudy)->format('M d, Y')}}</td>

                                                   <td><div class="form-inline">
                                                
                                            <a href="{{ route('student.edit', $row->id)}}" class="list-icons-item text-primary" title="Edit"><i class="icon-pencil7"></i></a> 
                                        &nbsp

                                  <div class="dropdown">
                               <a href="#" class="list-icons-item dropdown-toggle text-teal" data-toggle="dropdown"><i class="icon-cog6"></i></a>
		      <div class="dropdown-menu">
                <li> <a class="nav-link" href="#" data-toggle="modal" data-target="#appFormModal"   data-id="{{ $row->id }}" data-type="disable"   onclick="model({{ $row->id }},'disable')"    data-toggle="modal" data-target="#appFormModal" >Disable Student</a>  </li>
                                                                   
                                                          
                            </div></div>
                             
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
                                        <h5>Create Student</h5>
                                        @else
                                        <h5>Edit Student</h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                 @if(isset($id))
                                                {{ Form::model($id, array('route' => array('student.update', $id), 'method' => 'PUT')) }}
                                                @else
                                                {{ Form::open(['route' => 'student.store','role'=>'form','enctype'=>'multipart/form-data']) }}
                                                @method('POST')
                                               @endif

                                                                     <div class="form-group row">
                                                                    <label class="col-lg-2 col-form-label">Student Full Name <span class="required">*</span> </label>
                                                                          <div class="col-lg-8">   
                                                                    <input type="text" required name="student_name" class="form-control" required placeholder=""  value="{{ isset($data) ? $data->student_name : ''}}">
                                                                </div>
                                                                    </div>

                                                             <div class="form-group row"><label class="col-lg-2 col-form-label">Student Gender <span class="required">*</span></label>
                                                    <div class="col-lg-8">
                                                    <select class="form-control m-b" name="gender" required>
                                                 <option value="">Select Gender</option>
                                                
                                                      <option value="Male" @if(isset($data))@if($data->gender == 'Male') selected @endif @endif >Male</option>
                                                   <option value="Female" @if(isset($data))@if($data->gender == 'Female') selected @endif @endif >Female</option>
                                                      
                                                        </select>
                                                    </div>
                                                </div>

                                                                <div class="form-group row">
                                                                    <label class="col-lg-2 col-form-label">Parent Full Name <span class="required">*</span></label> 
                                                                   <div class="col-lg-8">  
                                                                    <input type="text" name="parent_name" class="form-control" required placeholder=""  value="{{ isset($data) ? $data->parent_name : ''}}">
                                                                </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <label class="col-lg-2 col-form-label">Parent Phone Number <span class="required">*</span> </label>
                                                                     <div class="col-lg-8">  
                                                                    <input type="text"  name="parent_phone" class="form-control" placeholder="0713000000"   pattern="[0]{1}[0-9]{9}" required  value="{{ isset($data) ? $data->parent_phone : ''}}">
                                                                </div>
                                                                    </div>
                                                                 
                                                                 <div class="form-group row">
                                                                    <label class="col-lg-2 col-form-label"> School Level <span class="required">*</span></label>  
                                                                <div class="col-lg-8">                                
                                                                <select name="level" class="form-control m-b level " required>
                                                                <option value="">Select School Level</option>
                                                                 @foreach ($level as $lv)                                                             
                                                            <option value="{{$lv->level}}" @if(isset($data))@if($data->level == $lv->level) selected @endif @endif >{{$lv->level}}</option>
                                                               @endforeach
                                                                </select>
                                                                </div>
                                                                 </div>
                                                                
                                                              @if(!@empty($data->class)) 
                                                             <div class="form-group row">
                                                                    <label class="col-lg-2 col-form-label"> Class <span class="required">*</span></label>  
                                                                <div class="col-lg-8">                                 
                                                                <select name="level_class" class="form-control m-b class " id="class" required>
                                                                <option value="">Select Class </option>
                                                                        @foreach ($class as $c)                                                             
                                                            <option value="{{$c->id}}" @if(isset($data))@if($data->class == $c->class) selected @endif @endif >{{$c->class}}</option>
                                                               @endforeach
                                                                </select>
                                                                </div>
                                                                </div>
                                                              @else
                                                                  <div class="form-group row">
                                                                    <label class="col-lg-2 col-form-label"> Class <span class="required">*</span></label>  
                                                                <div class="col-lg-8">                                 
                                                                <select name="level_class" class="form-control m-b class " id="class" required>
                                                                <option value="">Select Class </option>
                                                            
                                                                </select>
                                                                </div>
                                                                </div>
                                                              @endif

                                                       <div class="form-group row">
                                                                    <label class="col-lg-2 col-form-label">Registration Date <span class="required">*</span> </label>
                                                                     <div class="col-lg-8">  
                                                                    <input type="date" required name="yearStudy" class="form-control" required  value="{{ isset($data) ? $data->yearStudy : ''}}">
                                                                </div>
                                                                    </div>

                                                      <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                        @if(!@empty($id))      
                                                                                                                                                          
                                                <a href="{{ route('student.index')}}" class="btn btn-sm btn-danger float-right m-t-n-xs" >Cancel</a> 
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

                                 <div class="tab-pane fade " id="importExel" role="tabpanel"
                            aria-labelledby="importExel-tab">

                            <div class="card">
                                <div class="card-header">
                                     <form action="{{ route('student.sample') }}" method="POST" enctype="multipart/form-data">
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
                                                <form action="{{ route('student.import') }}" method="POST" enctype="multipart/form-data">
                                            
                                                    @csrf
                                                    <div class="form-group mb-4">
                                                        <div class="custom-file text-left">
                                                            <input type="file" name="file" class="form-control" id="customFile" required>
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-primary">Import Students</button>
                                          
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
    <div class="modal-dialog ">
    </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">
    function model(id, type) {

        let url = '{{ route("student.show", ":id") }}';
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
        $.ajax({
            url: '{{url("school/findLevel")}}',
            type: "GET",
            data: {
                id: id
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                $("#class").empty();
                $("#class").append('<option value="">Select Class</option>');
                $.each(response,function(key, value)
                {
                 
                    $("#class").append('<option value=' + value.id+ '>' + value.class + '</option>');
                   
                });                      
               
            }

        });

    });

});
</script>
@endsection