                                              <div class="card-header"> <strong></strong> </div>
                                                
                                            <div class="card-body">
                                                <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                                    <li class="nav-item">
                         <a class="nav-link @if($type == 'credit' || $type == 'details' || $type == 'calendar' || $type == 'purchase' || $type == 'invoice' || $type == 'comments' || $type == 'attachment' || $type == 'milestone' || $type == 'tasks' || $type == 'expenses' || $type == 'estimate' || $type == 'notes' || $type == 'activities' ) active  @endif" id="home-tab2" data-toggle="tab"
                                                            href="#est-home2" role="tab" aria-controls="home" aria-selected="true">Proforma Invoice
                                                            List</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link @if($type == 'edit-estimate') active  @endif" id="profile-tab2"
                                                            data-toggle="tab" href="#est-profile2" role="tab" aria-controls="profile"
                                                            aria-selected="false">New Proforma Invoice</a>
                                                    </li>
                                    
                                                </ul>
                                                <br>
                                                <div class="tab-content tab-bordered" id="myTab3Content">
                                <div class="tab-pane fade @if($type == 'credit' || $type == 'details' || $type == 'calendar' || $type == 'purchase' || $type == 'invoice' || $type == 'comments' || $type == 'attachment' || $type == 'milestone' || $type == 'tasks' || $type == 'expenses' || $type == 'estimate' || $type == 'notes' || $type == 'activities' ) active show  @endif " id="est-home2" role="tabpanel"
                                                        aria-labelledby="home-tab2">
                                                        <div class="table-responsive">
                                                            <table class="table datatable-est table-striped" style="width:100%">
                                                                <thead>
                                                                    <tr role="row">                                    
                                    
                                                     <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 156.484px;">Ref No</th>
                                                       <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Client Name</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 136.484px;">Invoice Date</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 161.219px;">Due Amount</th>
                                                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Location</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 121.219px;">Status</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 128.1094px;">Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                    @if(!empty($prof))
                                                                     @foreach ($prof as $row)
                                                                    <tr class="gradeA even" role="row">
                                                             <td>
                                                    <a class="nav-link" id="profile-tab2"
                                                            href="{{ route('invoice.show',$row->id)}}" role="tab"
                                                            aria-selected="false">{{$row->reference_no}}</a>
                                                </td>
                                                    <td>{{$row->client->name }}  </td>
                                                <td>{{$row->invoice_date}}</td>

                                                <td>{{number_format($row->due_amount,2)}} {{$row->exchange_code}}</td>
                                     <td>{{$row->store->name}}</td>
                                                <td>
                                                    @if($row->status == 0)
                                                    <div class="badge badge-danger badge-shadow">Not Approved</div>
                                                    @elseif($row->status == 1)
                                                    <div class="badge badge-warning badge-shadow">Not Paid</div>
                                                    @elseif($row->status == 2)
                                                    <div class="badge badge-info badge-shadow">Partially Paid</div>
                                                    @elseif($row->status == 3)
                                                    <span class="badge badge-success badge-shadow">Fully Paid</span>
                                                    @elseif($row->status == 4)
                                                    <span class="badge badge-danger badge-shadow">Cancelled</span>

                                                    @endif
                                                </td>
                                                <td>
                                        <div class="form-inline">

                                     <a class="list-icons-item text-primary" title="Edit"  href="{{route('edit.project_details',['type'=>'edit-estimate','type_id'=>$row->id])}}"><i class="icon-pencil7"></i></a>&nbsp
                                  <a class="list-icons-item text-danger" title="Edit"  href="{{route('delete.project_details',['type'=>'delete-estimate','type_id'=>$row->id])}}" onclick= "return confirm('Are you sure, you want to delete?')"><i class="icon-trash"></i></a>&nbsp&nbsp


               <div class="dropdown">
							                		<a href="#" class="list-icons-item dropdown-toggle text-teal" data-toggle="dropdown"><i class="icon-cog6"></i></a>
                                                                <div class="dropdown-menu">
                                                            @if($row->invoice_status == 0)
                                                          <a class="nav-link" onclick="return confirm('Are you sure?')"   href="{{ route('project.convert_to_invoice', $row->id)}}"  title="" > Convert To Invoice </a>
                                                         
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
                                                    <div class="tab-pane fade  @if($type == 'edit-estimate') active show @endif" id="est-profile2"
                                                        role="tabpanel" aria-labelledby="profile-tab2">
                                    <br>
                                                        <div class="card">
                                                            <div class="card-header">
                                                              @if($type == 'edit-estimate')
                                        <h5>Edit Proforma Invoice</h5>
                                        @else
                                        <h5>Add New Proforma Invoice</h5>
                                        @endif
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-sm-12 ">
                                                                      @if($type == 'edit-estimate')

                                                                       {!! Form::open(array('route' => 'update.project_details',"enctype"=>"multipart/form-data")) !!}
                                                                         <input type="hidden" name="id" value="{{ $type_id}}">
                                                                        @else
                                                                        {!! Form::open(array('route' => 'save.project_details',"enctype"=>"multipart/form-data")) !!}                                                                                                                             
                                                                        @method('POST')
                                                                        @endif                                                                     
                                                                        

                                                                     <input type="hidden" name="project_id" value="{{ $id}}">
                                                                          <input type="hidden" name="type" value="estimate">

                                                                        <div class="form-group row">
                                                                              <label class="col-lg-2 col-form-label">Client Name <span class="text-danger">*</span></label>
                                                    <div class="col-lg-4">
                                                            <select class="form-control m-b" name="client_id" required
                                                                id="client_id">
                                                                <option value="">Select Client Name</option>
                                                                @if(!empty($client))
                                                                @foreach($client as $row)

                                                                <option @if(isset($edit_data))
                                                                    {{  $edit_data->client_id == $row->id  ? 'selected' : ''}}
                                                                    @endif value="{{ $row->id}}">{{$row->name}}</option>

                                                                @endforeach
                                                                @endif

                                                            </select>
                                                            </div>

                                                       <label class="col-lg-2 col-form-label">Location <span class="text-danger">*</span></label>
                                                                           <div class="col-lg-4">
                                                                               <select class="form-control m-b est_location" name="location" required
                                                        id="location">
                                                        <option value="">Select Location</option>
                                                        @if(!empty($location))
                                                        @foreach($location as $loc)

                                                        <option @if(isset($edit_data))
                                                            {{  $edit_data->location == $loc->id  ? 'selected' : ''}}
                                                            @endif value="{{ $loc->id}}">{{$loc->name}}</option>

                                                        @endforeach
                                                        @endif

                                                    </select>
                                                             
                                                                            </div>
                                                                        </div>


                                                                       
                                                                        <div class="form-group row">
                                                                            <label class="col-lg-2 col-form-label">Invoice Date  <span class="text-danger">*</span></label>                                                                                                        
                                                                            <div class="col-lg-4">
                                                                             <input type="date" name="invoice_date" required  placeholder=""  value="{{ isset($edit_data) ? $edit_data->invoice_date : date('Y-m-d')}}"   class="form-control">                                                         
                                                                            </div>
                                                                         <label class="col-lg-2 col-form-label">End Date<span class="text-danger">*</span></label>                                                                                                        
                                                                            <div class="col-lg-4">
                                                                             <input type="date" name="due_date" required  placeholder=""  value="{{ isset($edit_data) ? $edit_data->due_date : strftime(date('Y-m-d', strtotime("+10 days")))}}"   class="form-control">                                                         
                                                                            </div>
                        
                                                                       
                                                                    </div>


                                                       <br>
                                                <h4 align="center">Enter Item Details</h4>
                                                <hr>
                                               <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Currency</label>
                                                    <div class="col-lg-4">
                                                       @if(!empty($edit_data->exchange_code))

                              <select class="form-control m-b" name="exchange_code" id="currency_code" required >
                            <option value="{{ old('currency_code')}}" disabled selected>Choose option</option>
                            @if(isset($currency))
                            @foreach($currency as $row)
                            <option  @if(isset($edit_data)) {{$edit_data->exchange_code == $row->code ? 'selected' : 'TZS' }} @endif  value="{{ $row->code }}">{{ $row->name }}</option>
                            @endforeach
                            @endif
                        </select>

                         @else
                       <select class="form-control m-b" name="exchange_code" id="currency_code" required >
                            <option value="{{ old('currency_code')}}" disabled >Choose option</option>
                            @if(isset($currency))
                            @foreach($currency as $row)

                           @if($row->code == 'TZS')
                            <option value="{{ $row->code }}" selected>{{ $row->name }}</option>
                           @else
                          <option value="{{ $row->code }}" >{{ $row->name }}</option>
                           @endif

                            @endforeach
                            @endif
                        </select>


                     @endif
                                                    </div>
                                                    <label class="col-lg-2 col-form-label">Exchange Rate</label>
                                                    <div class="col-lg-4">
                                                        <input type="number" name="exchange_rate"
                                                            placeholder="1 if TZSH"
                                                            value="{{ isset($edit_data) ? $edit_data->exchange_rate : '1.00'}}"
                                                            class="form-control" required>
                                                    </div>
                                                </div>


                                          <hr>
                                                <button type="button" name="add" class="btn btn-success btn-xs est_add"><i
                                                        class="fas fa-plus"> Add item</i></button><br>
                                                <br>
                                                <div class="table-responsive">
                                                <table class="table table-bordered" id="est_cart">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Quantity</th>
                                                            <th>Price</th>
                                                           
                                                            <th>Tax</th>
                                                            <th>Total</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>


                                                    </tbody>
                                                    <tfoot>
                                                        @if(!empty($type_id))
                                                        @if(!empty($items))
                                                        @foreach ($items as $i)
                                                        <tr class="line_items">
                                                            <td><select name="item_name[]"
                                                                    class="form-control  m-b est_item_name" required
                                                                    data-sub_category_id={{$i->order_no}}>
                                                                    <option value="">Select Item</option>
                                                                       @if(!empty($name))
                                                                     @foreach ($name as $n)
                                                                
                                                                     <option value="{{ $n->id}}"
                                                                        @if(isset($i))@if($n->id == $i->item_name)
                                                                        selected @endif @endif >{{$n->name}}</option>
                                                                    @endforeach
                                                                           @endif
                                                                </select></td>
                                                            <td><input type="number" name="quantity[]"
                                                                   class="form-control est_item_quantity" data-category_id="{{$i->order_no}}"
                                                                    placeholder="quantity" id="quantity"
                                                                    value="{{ isset($i) ? $i->quantity : ''}}"
                                                                    required /><div class=""> <p class="form-control-static est_errors{{$i->order_no}}" id="errors" style="text-align:center;color:red;"></p>   </div></td>
                                                            <td><input type="text" name="price[]"
                                                                    class="form-control est_item_price{{$i->order_no}}"
                                                                    placeholder="price" required
                                                                    value="{{ isset($i) ? $i->price : ''}}" /></td>
                                                           <input type="hidden" name="unit[]"
                                                                    class="form-control est_item_unit{{$i->order_no}}"
                                                                    placeholder="unit" required
                                                                    value="{{ isset($i) ? $i->unit : ''}}" />
                                                            <td><select name="tax_rate[]"
                                                                    class="form-control  m-b item_tax'+count{{$i->order_no}}"
                                                                    required>
                                                                    <option value="0">Select Tax Rate</option>
                                                                    <option value="0" @if(isset($i))@if('0'==$i->
                                                                        tax_rate) selected @endif @endif>No tax</option>
                                                                    <option value="0.18" @if(isset($i))@if('0.18'==$i->
                                                                        tax_rate) selected @endif @endif>18%</option>
                                                                </select></td>
                                                            <input type="hidden" name="total_tax[]"
                                                                class="form-control item_total_tax{{$i->order_no}}'"
                                                                placeholder="total" required
                                                                value="{{ isset($i) ? $i->total_tax : ''}}" readonly
                                                                jAutoCalc="{quantity} * {price} * {tax_rate}" />
                                                            <input type="hidden" name="saved_items_id[]"
                                                                class="form-control item_saved{{$i->order_no}}"
                                                                value="{{ isset($i) ? $i->id : ''}}"
                                                                required />
                                                            <td><input type="text" name="total_cost[]"
                                                                    class="form-control item_total{{$i->order_no}}"
                                                                    placeholder="total" required
                                                                    value="{{ isset($i) ? $i->total_cost : ''}}"
                                                                    readonly jAutoCalc="{quantity} * {price}" /></td>
                                                               <input type="hidden" id="item_id"  class="form-control est_item_id{{$i->order_no}}" value="{{$i->items_id}}" />
                                                            <input type="hidden" name="items_id[]"
                                                                class="form-control name_list"
                                                                value="{{ isset($i) ? $i->id : ''}}" />
                                                            <td><button type="button" name="remove"
                                                                    class="btn btn-danger btn-xs est-rem"
                                                                    value="{{ isset($i) ? $i->id : ''}}"><i class="icon-trash"></i></button></td>
                                                        </tr>

                                                        @endforeach
                                                        @endif
                                                        @endif

                                                        <tr class="line_items">
                                                            <td colspan="3"></td>
                                                            <td><span class="bold">Sub Total </span>: </td>
                                                            <td><input type="text" name="subtotal[]"
                                                                    class="form-control item_total"
                                                                    placeholder="subtotal" required
                                                                    jAutoCalc="SUM({total_cost})" readonly></td>
                                                        </tr>
                                                        <tr class="line_items">
                                                            <td colspan="3"></td>
                                                            <td><span class="bold">Tax </span>: </td>
                                                            <td><input type="text" name="tax[]"
                                                                    class="form-control item_total" placeholder="tax"
                                                                    required jAutoCalc="SUM({total_tax})" readonly>
                                                            </td>
                                                        </tr>
                                                        
                                                        <tr class="line_items">
                                                            <td colspan="3"></td>
                                                            <td><span class="bold">Total</span>: </td>
                                                            <td><input type="text" name="amount[]"
                                                                    class="form-control item_total" placeholder="total"
                                                                    required jAutoCalc="{subtotal} + {tax}" readonly>
                                                            </td>
                                                          
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>


                                 
                                                                     
                                    
                                                                    <div class="form-group row">
                                                                        <div class="col-lg-offset-2 col-lg-12">
                                                                            @if($type == 'edit-estimate')
                                                                            <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                                                data-toggle="modal" data-target="#myModal"
                                                                                type="submit" id="est_save">Update</button>
                                                                            @else
                                                                            <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                                                type="submit" id="est_save">Save</button>
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
												            
											


											
				