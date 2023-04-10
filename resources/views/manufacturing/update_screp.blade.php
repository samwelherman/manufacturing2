<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="formModal">
            Clearing </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    {!! Form::open(['route' => ['screp.update', $id], 'method' => 'POST']) !!}
    @csrf
    @method('PUT')
    <div class="modal-body">


        <div class="form-group row">
         

            {{-- screps section --}}


            <div class="col-lg-6">

                <label class="col-lg-12 col-form-label">Screp returned as raw material in Kg</label>

                <div class="col-lg-12">

                    <input type="number" name="baalance" placeholder="" step="0.1" min="0"
                        class="form-control user" required>

                </div>
            </div>

            <div class="col-lg-6">

                <label class="col-lg-12 col-form-label">Screp completely wasted in Kg</label>

                <div class="col-lg-12">
                    <input type="number" name="wasted" placeholder="" step="0.1" min="0"
                    class="form-control user" required>

                </div>
            </div>

        </div>
    </div>


    <div class="modal-footer ">
        <button class="btn btn-primary" type="submit" id="save"><i
                class="icon-checkmark3 font-size-base mr-1"></i>Save</button>
        <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i>
            Close</button>
    </div>

    {{ Form::close() }}

</div>
</div>

@yield('scripts')
<script>
    $('.datatable-modal').DataTable({
        autoWidth: false,
        "columnDefs": [{
            "targets": [1]
        }],
        dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
        "language": {
            search: '<span>Filter:</span> _INPUT_',
            searchPlaceholder: 'Type to filter...',
            lengthMenu: '<span>Show:</span> _MENU_',
            paginate: {
                'first': 'First',
                'last': 'Last',
                'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;',
                'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;'
            }
        },

    });
</script>
