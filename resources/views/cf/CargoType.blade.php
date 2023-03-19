<div class="card-header"> <strong></strong> </div>
                                                
                                            <div class="card-body">
                                                <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                                    <li class="nav-item">
                         <a class="nav-link @if($type == 'credit' || $type == 'details' || $type == 'calendar' || $type == 'purchase' || $type == 'debit' || $type == 'invoice' || $type == 'comments' || $type == 'attachment' || $type == 'milestone' || $type == 'tasks' || $type == 'expenses' || $type == 'estimate' || $type == 'notes' || $type == 'activities'|| $type ==' logistic' ||  $type == 'cargo' || $type == 'storage' || $type == 'charge' )  active  @endif" id="cargo-tab1" data-toggle="tab"
                                                            href="#cargo-home" role="tab" aria-controls="home" aria-selected="true">Cargo Type
                                                            List</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link @if($type == 'edit-cargo') active  @endif" id="cargo-tab2"
                                                            data-toggle="tab" href="#cargo-profile" role="tab" aria-controls="profile"
                                                            aria-selected="false">New Cargo Type</a>
                                                    </li>
                                    
                                                </ul>
                                                <br>
                                                <div class="tab-content tab-bordered" id="myTab3Content">
                                                    <div class="tab-pane fade @if($type == 'credit' || $type == 'details' || $type == 'calendar' || $type == 'purchase' || $type == 'debit' || $type == 'invoice' || $type == 'comments' || $type == 'attachment' || $type == 'milestone' || $type == 'tasks' || $type == 'expenses' || $type == 'estimate' || $type == 'notes' || $type == 'activities'|| $type ==' logistic' ||  $type == 'cargo' || $type == 'storage' || $type == 'charge' )  active show  @endif " id="cargo-home" role="tabpanel"
                                                        aria-labelledby="cargo-tab1">
                                                        <div class="table-responsive">
                                                            <table class="table datatable-mile table-striped" style="width:100%">
                                                                <thead>
                                                                    <tr role="row">                                    
                                                 <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 156.484px;">#</th>
                                                 <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 156.484px;">Cargo Name</th>
                                                 <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 121.219px;">Route</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 121.219px;">Loaded Date</th>
                                                 <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 121.219px;">Storage Start Date</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                         @if(!@empty($CargoType))
                                                            @foreach ($CargoType as $row)
                                                            <tr class="gradeA even" role="row">
                                                            <td>{{$loop->iteration}}</td>
                                                             @php $cargo_name = App\Models\CF\Cargo::find($row->name_id)->name; @endphp
                                                            <td>{{$cargo_name}}</td>
                                                             @php $a = App\Models\Route::find($row->route_id)->from.' - '. App\Models\Route::find($row->route_id)->to; @endphp
                                                            <td>{{$row->Country}}</td>                                                                                             
                                                            <td>{{$row->loaded_date}}</td>
                                                             <td>{{$row->storage_start_date}}</td>
                                                <td>
                                        <div class="form-inline">

    <a class="list-icons-item text-primary" title="Edit"  href="{{route('edit.cf_details',['type'=>'edit-cargo','type_id'=>$row->id])}}"><i class="icon-pencil7"></i></a>&nbsp
 <a class="list-icons-item text-danger" title="Edit"  href="{{route('delete.cf_details',['type'=>'delete-cargo','type_id'=>$row->id])}}" onclick= "return confirm('Are you sure, you want to delete?')"><i class="icon-trash"></i></a>&nbsp
                  

    <div class="dropdown">
           <a  href="#" class="list-icons-item dropdown-toggle text-teal" data-toggle="dropdown"><i class="icon-cog6"></i></a>
                               <div class="dropdown-menu">
               
               <a  class="nav-link" data-toggle="modal" data-target="#exampleModal">
                     Storage
                   </a>        
                      <a  class="nav-link" data-toggle="modal" data-target="#charge">
                     Charge
                   </a>
                   <a class="nav-link"  href=""  data-toggle="modal" value="{{ $data->id}}" data-type="cargotype" data-target="#app2FormModal" onclick="model({{$row->id }},'cargotype')">Logistic</a>
                      
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
                                                    <div class="tab-pane fade  @if($type == 'edit-cargo') active show @endif" id="cargo-profile"
                                                        role="tabpanel" aria-labelledby="cargo-tab2">
                                    <br>
                                                        <div class="card">
                                                            <div class="card-header">
                                                    @if($type == 'edit-cargo')
                                                        <h5>Edit Cargo Type</h5>
                                                        @else
                                                        <h5>Add New Cargo Type</h5>
                                                        @endif
                                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-sm-12 ">
                                                                      @if($type == 'edit-cargo')

                                                                       {!! Form::open(array('route' => 'update.cf_details',"enctype"=>"multipart/form-data")) !!}
                                                                         <input type="hidden" name="id" value="{{ $type_id}}">
                                                                        @else
                                                                        {!! Form::open(array('route' => 'save.cf_details',"enctype"=>"multipart/form-data")) !!}                                                                                                                             
                                                                        @method('POST')
                                                                        @endif                                                                     
                                                                        

                                                                     <input type="hidden" name="project_id" value="{{ $id}}">
                                                                          <input type="hidden" name="type" value="cargoType">

                                                                       <div class="form-group row"><label
                                                                                class="col-lg-2 col-form-label">Cargo Name</label>
                                                                            <div class="col-lg-8">
                                                                        <select class="m-b account_id" id="user_id" name="name_id" required>
                                                                            <option value="">Select </option>                                                    
                                                                                    @foreach ($Cargo as $row)                                                             
                                                                                    <option value="{{$row->id}}" @if(isset($edit_data))@if($edit_data->responsible_id == $row->id) selected @endif @endif >{{$row->name}}</option>
                                                                                       @endforeach
                                                                                     </select>
                                                                            </div>
                                                                        </div>


                                                                         <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Activity Type</label>
                                                    <div class="col-lg-8">
                                                <select class="m-b account_id related_class" id="goal_tracking_id" name="goal_tracking_id" required>
                                                              <option value="">Select Related</option>                                                     
                                                            <option value="Clearing" @if(isset($data))@if($data->goal_tracking_id == 'Clients') selected @endif @endif >Clearing</option>
                                                            <option value="Forwading" @if(isset($data))@if($data->goal_tracking_id == 'Departments') selected @endif @endif >Forwading</option>
                                                             </select>
                                                    </div>
                                                </div>
                                                
                                                <div id="projectDiv" style="display:none">
                                                
                                                <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Select Here</label>
                                                    <div class="col-lg-8">
                                                <select class="form-control m-b account_id" id="client_id" name="activity_type">
                                                    <option value="">Select Here</option>
                                                            @foreach ($country as $row)                                                             
                                                            <option value="{{$row->value}}" @if(isset($data))@if($data->department_id == $row->id) selected @endif @endif >{{$row->value}}</option>
                                                               @endforeach                                                    
                                                             </select>
                                                    </div>
                                                </div>
                                                
                                                </div>
    
                                                <div id="leadsDiv" style="display:none">
                                                
                                                 <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Country</label>
                                                    <div class="col-lg-8">
                                                <select class="m-b account_id" id="department_id" name="activity_type">
                                                    <option value="">Select Here</option>                                                    
                                                           @foreach ($country as $row)                                                             
                                                            <option value="{{$row->value}}" @if(isset($data))@if($data->department_id == $row->id) selected @endif @endif >{{$row->value}}</option>
                                                               @endforeach
                                                             </select>                                                     
                                                    </div>
                                                </div>
                                                
                                                </div>  
                                                                   
                                                                      <div class="form-group row">
                                                                        <label class="col-lg-2 col-form-label">Loaded Date</label>
                                                                        <div class="col-lg-8">
                                                                            <input type="date" name="loaded_date" required
                                                                                placeholder=""
                                                                               value="{{ isset($edit_data) ? $edit_data->end_date : date('Y-m-d')}}" 
                                                                                class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    
                                                                <div class="form-group row">
                                                                        <label class="col-lg-2 col-form-label">Storage Start Date </label>
                                                                        <div class="col-lg-8">
                                                                            <input type="date" name="storage_start_date" required
                                                                                placeholder=""
                                                                               value="{{ isset($edit_data) ? $edit_data->end_date : date('Y-m-d')}}" 
                                                                                class="form-control">
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                        <div class="col-lg-offset-2 col-lg-12">
                                                                            @if($type == 'edit-cargo')
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
                            <script type="text/javascript">
$(document).ready(function() {

    $(document).on('change', '.related_class', function() {


        var id = $(this).val();

        if (id == 'Clients') {
            $('#projectDiv').show();
            $('#leadsDiv').hide();
        } else if (id == 'Departments') {
            $('#projectDiv').hide();
            $('#leadsDiv').show();
        }


    });
});
</script>                
                                            