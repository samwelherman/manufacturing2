<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Assign Fuel and Mileage</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        {{ Form::model($id, array('route' => array('order_movement.update', $id), 'method' => 'PUT')) }}
        <div class="modal-body">

         <p><strong>Make sure you enter valid information</strong> .</p>
             <ul>
                @php
                   $data=App\Models\CargoLoading::find($id); 
                @endphp
                <li>Truck : {{ $data->truck->truck_name}} - {{ $data->truck->reg_no}}</li>
               <li>Driver Name: {{ $data->driver->driver_name}} </li>
              <li>Route Name: From {{ $data->route->from}} to  {{ $data->route->to}} 
            @if(!empty($data->end))
                 - {{$data->end}}
            @endif
 </li>
       @if(!empty($data->receipt))
        <li>Receipt: {{ $data->receipt}} </li>
            @endif
            </ul>

          <div class="form-group">
                <label class="col-lg-6 col-form-label"> Fuel Used In Litre </label>

                <div class="col-lg-12">
                   <input type="number" step="0.001"  name="fuel" value="" required class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-6 col-form-label">Millege paid </label>

                <div class="col-lg-12">
                    <input type="number" step="0.001" name="mileage" value="" required class="form-control">
                    
                </div>
            </div>

    
  <div class="form-group">
                <label class="col-lg-6 col-form-label">Road Toll </label>

                <div class="col-lg-12">
                    <input type="number" step="0.001" name="road_toll" value=""  class="form-control">
                    
                </div>
            </div>
  <div class="form-group">
                <label class="col-lg-6 col-form-label">Toll Gate </label>

                <div class="col-lg-12">
                    <input type="number" step="0.001" name="toll_gate" value=""  class="form-control">
                    
                </div>
            </div>
  <div class="form-group">
                <label class="col-lg-6 col-form-label">Council </label>

                <div class="col-lg-12">
                    <input type="number" step="0.001" name="council" value=""  class="form-control">
                    
                </div>
            </div>
  <div class="form-group">
                <label class="col-lg-6 col-form-label">Consultant </label>

                <div class="col-lg-12">
                    <input type="number" step="0.001" name="consultant" value=""  class="form-control">
                    
                </div>
            </div>
          
  <div class="form-group">
   <label class="col-lg-6 col-form-label"> Date</label>
                                                    <div class="col-lg-12">
                                                        <input type="date" name="date"
                                                            placeholder="0 if does not exist"
                                                            value="{{ date('Y-m-d')}}" 
                                                            class="form-control">
                                                    </div>
                                                     </div>

                    <input type="hidden" name="type" value="fuel" required class="form-control">
            


        </div>
        <div class="modal-footer bg-whitesmoke br">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>