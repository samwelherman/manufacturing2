@extends('layouts.master')

@section('content')

<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Truck Details For {{$truck->truck_name}} - {{$truck->reg_no}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-2">
                                <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link "  id="#tab1" 
                                        href="{{ route('truck.insurance', $truck->id)}}"  aria-controls="home"
                                            aria-selected="true">Insurance</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="#tab2" 
                                            href="{{ route('truck.sticker', $truck->id)}}"  aria-controls="profile"
                                            aria-selected="false">LATRA Sticker</a>
                                    </li>
                              <li class="nav-item">
                                        <a class="nav-link" id="#tab2" 
                                            href="{{ route('truck.permit', $truck->id)}}"  aria-controls="profile"
                                            aria-selected="false">Road Permit</a>
                                    </li>
                                <li class="nav-item">
                                        <a class="nav-link" id="#tab2" 
                                            href="{{ route('truck.comesa', $truck->id)}}"  aria-controls="profile"
                                            aria-selected="false">COMESA</a>
                                    </li>
                                <li class="nav-item">
                                        <a class="nav-link" id="#tab2" 
                                            href="{{ route('truck.carbon', $truck->id)}}"  aria-controls="profile"
                                            aria-selected="false">CARBON</a>
                               <li class="nav-item">
                                        <a class="nav-link " id="#tab3" 
                                            href="{{ route('truck.fuel', $truck->id)}}"  aria-controls="profile"
                                            aria-selected="false">Fuel Report</a>
                                    </li>

                               <li class="nav-item">
                                        <a class="nav-link active"  id="#tab4" 
                                            href="{{ route('truck.route', $truck->id)}}"  aria-controls="profile"
                                            aria-selected="false">Routes</a>
                                    </li>
                                   
                                  
                                     


                                </ul>
                            </div>
                            <div class="col-12 col-sm-12 col-md-10">
                                <div class="tab-content no-padding" id="myTab2Content">
                                    <div class="tab-pane fade @if($type =='route') active show  @endif" id="tab1"
                                    role="tabpanel" aria-labelledby="tab1">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4></h4>
                                        </div>
                                        <div class="card-body">
                                           
                                            <div class="tab-content tab-bordered" id="myTab3Content">


                                  <div class="panel-heading">
            <h5 class="panel-title">
               Route Report
              @if(!empty($start_date))
                    for the period: <b>{{$start_date}} to  {{$end_date}}</b>
                @endif
            </h5>
        </div>

<br>
        <div class="panel-body hidden-print">
            {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form')) !!}
            <div class="row">

                <div class="col-md-4">
                    <label class="">Start Date</label>
                    {!! Form::date('start_date',$start_date, array('class' => 'form-control date-picker', 'placeholder'=>"First Date",'required'=>'required')) !!}
                </div>
                <div class="col-md-4">
                    <label class="">End Date</label>
                   {!! Form::date('end_date',$end_date, array('class' => 'form-control date-picker', 'placeholder'=>"Third Date",'required'=>'required')) !!}
                </div>

   <div class="col-md-4">
                      <br><button type="submit" class="btn btn-success">Search</button>
                        <a href="{{Request::url()}}"class="btn btn-danger">Reset</a>

                </div>                  
                </div>
           
            {!! Form::close() !!}

        </div>

        <!-- /.panel-body -->

   <br>
                                                <div class="tab-pane fade @if($type =='route') active show @endif" id="home2" role="tabpanel"
                                                    aria-labelledby="home-tab2">
                                                    <div class="table-responsive">
                                                         <table class="table datatable-basic table-striped">
                                                            <thead>
                                                                <tr>
                                
                                                                    <th>#</th>
                        <th>Date</th>
<th>Driver</th>
           <th>REF NO</th>
 <th>Shipment Name</th>
                 <th>Route Name</th>
                        <th>Status</th>
                  
                       
    
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if(!@empty($route))
                                                                @foreach ($route as $row)
                                                                <tr class="gradeA even" role="row">
                                                                    <td>{{ $loop->iteration }}</td>                                                                    
                                                                    <td>{{Carbon\Carbon::parse($row->collection_date)->format('d/m/Y')}}</td>
                                                                   <td>{{$row->driver->driver_name}}</td> 
                                                                    <td>{{$row->pacel_number}}</td>  
                                                                    <td>{{$row->pacel_name}}</td>  
                                                                    <td>From {{$row->route->from}} to {{$row->route->to}}</td>
                                                                    <td>
                                                    @if($row->status == 3)
                                                    <div class="badge badge-success badge-shadow">Collected</div>
                                                       @elseif($row->status == 4)
                                                    <div class="badge badge-success badge-shadow">Loaded</div>
                                                       @elseif($row->status == 5)
                                                    <div class="badge badge-info badge-shadow">Offloaded</div>
                                                      @elseif($row->status == 6)
                                                    <div class="badge badge-success badge-shadow">Delivered</div>
                                                    @endif
                                                </td>
                                              
                                               
                                                                
                                                                 
                                
                                                                   
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>
<script>
    function myFunction() {
       // alert('hellow')
  //var element = document.getElementById("#tab2");
  //element.classList.add("active");
}
</script>
<script type="text/javascript">
 $(document).ready(function(){
  $("#datepicker,#datepicker2").datepicker({
     format: "yyyy",
     viewMode: "years", 
     minViewMode: "years",
     autoclose:true
  });   
})

 </script>
@endsection