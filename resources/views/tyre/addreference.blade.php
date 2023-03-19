
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Assign Tyre Serial No </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
      {{ Form::open(['route' => 'reference_tyre.save']) }}
             @method('POST')
        <div class="modal-body">
            <p><strong>Make sure you enter valid information</strong> .</p>
                     
                 <div class="form-group">
                <label class="col-lg-6 col-form-label">Serial No</label>

                <div class="col-lg-12">
                    
               <input type="text" name="reference" value="" required class="form-control">
                <input type="hidden" name="id" value="{{$id}}" required class="form-control">
                </div>
            </div>

          


        </div>
    <div class="modal-footer ">
             <button class="btn btn-primary"  type="submit" id="save" ><i class="icon-checkmark3 font-size-base mr-1"></i> Save</button>
         <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>
        {!! Form::close() !!}
    </div>
