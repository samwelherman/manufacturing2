@extends('layouts.master')

@push('plugin-styles')
  <link href="{{asset('calendar/css/main.min.css')}}" rel="stylesheet" type="text/css">
  <link href="{{asset('calendar/css/daygrid.min.css')}}" rel="stylesheet" type="text/css">
  <link href="{{asset('calendar/css/timegrid.min.css')}}" rel="stylesheet" type="text/css">


@endpush

@push('plugin-scripts')
<script src="{{asset('calendar/js/main.min.js')}}"></script>
<script src="{{asset('calendar/js/interaction.min.js')}}"></script>
<script src="{{asset('calendar/js/daygrid.min.js')}}"></script>
<script src="{{asset('calendar/js/timegrid.min.js')}}"></script>


<script>
$(document).ready(function() {
  var calendarEl = document.getElementById('calendar');

  var calendar = new FullCalendar.Calendar(calendarEl, {
    plugins: [ 'interaction', 'dayGrid', 'timeGrid' ],
defaultView: 'dayGridMonth',

    header: {
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth,timeGridWeek,timeGridDay'
    },
    events: [
   @foreach($projects as $project)
                {
                    title : '{{ $project->project_name }}',
                    start : '{{ $project->start_date }}',
                    url : '{{ route('project.show',$project->id) }}'
                },
                @endforeach

    ]
  });

  calendar.render();



});  
    </script>
	
	<!-- /theme JS files -->
@endpush
@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                

                <!-- Selectable -->
					<div class="card">
						<div class="card-header">
							<h5 class="card-title">Project According To Start Date in Calendar</h5>
						</div>
						
						<div class="card-body">
				
			<!--	<p class="mb-3">In this example, Fullcalendar allows a user to highlight multiple days or timeslots by clicking and dragging. To let the user make selections by clicking and dragging, the <code>interaction</code> plugin must be loaded and this option must be set to <code>true</code>. You can either load it separately or use a global bundle (default). To use, set <code>selectable</code> option to <code>true</code>.</p> -->

							<div class="fullcalendar-selectable" id="calendar"></div>
						</div>
					</div>
					<!-- /selectable -->


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
<script>
var minDate, maxDate;
 
// Custom filtering function which will search data in column four between two values
$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var min = minDate.val();
        var max = maxDate.val();
        var date = new Date( data[5] );
 
        if (
            ( min === null && max === null ) ||
            ( min === null && date <= max ) ||
            ( min <= date   && max === null ) ||
            ( min <= date   && date <= max )
        ) {
            return true;
        }
        return false;
    }
);



</script>
<script>
$(document).ready(function() {

    $(document).on('change', '.account_id', function() {
        var id = $(this).val();
  console.log(id);
      
 $.ajax({
            url: '{{url("gl_setup/findSupplier")}}',
            type: "GET",
            data: {
                id: id,
            },
 dataType: "json",
            success: function(data) {
              console.log(data); 
          $("#supplier").css("display", "none");
         if (data == 'OK') {
           $("#supplier").css("display", "block");   
}
     

 }

        });

    });



});

</script>
<script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>

@endsection