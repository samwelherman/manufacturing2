@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="card row">
                    <div class="card-header">
                        <h4>Invoices</h4>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>

                                <tr>

                                    <th scope="col">Name</th>
                                    <th scope="col">Due Amount</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($invoice))
                                @foreach($invoice as $row)
                                <tr>


                                    <td><a href="{{ route('payments.show', $row->id)}}">{{ $row->farmer->firstname}}
                                            </a></td>
                                    <td><a href="{{ route('payments.show', $row->id)}}">{{ $row->due_amount}}Tsh </a></td>
                                    <td> <a href="{{ route('payments.show', $row->id)}}">
                                            @if($row->status == 1)
                                            <div class="badge badge-info badge-shadow">Not Payed</div>
                                            @elseif($row->status == 2)
                                            <div class="badge badge-success badge-shadow">partial payed</div>
                                            @elseif($row->status == 3)
                                            <span class="badge badge-danger badge-shadow">Payed</span>
                                            @endif
                                        </a>
                                    </td>


                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        @if(empty($id))
                        <h5>Make Payments</h5>
                        @else
                        <h5>Edit Payments</h5>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 ">
                                @if(isset($id))
                                {{ Form::model($id, array('route' => array('invoice_payment.update', $id), 'method' => 'PUT')) }}
                                @else
                                {{ Form::open(['route' => 'invoice_payment.store']) }}
                                @method('POST')
                                @endif



                                <div class="form-group row">

                                    <label class="col-lg-2 col-form-label">Amount
                                    </label>
                                    <div class="col-lg-10">
                                        <input type="number" name="amount"
                                            value="{{ isset($data) ? $data->due_amount : ''}}" class="form-control">
                                            <input type="hidden" name="id"
                                            value="{{ isset($data) ? $data->id : ''}}" class="form-control">
                                    </div>
                                </div>


                                <div class="form-group row"><label class="col-lg-2 col-form-label">Payment Date</label>

                                    <div class="col-lg-10">
                                        <input type="date" name="date" value="{{ isset($data) ? $data->date : date('d/m/y')}}"
                                            class="form-control" required>
                                    </div>
                                </div>

                                <div class="form-group row"><label class="col-lg-2 col-form-label">Payment
                                        Methode</label>

                                    <div class="col-lg-10">
                                        <select class="form-control m-b" name="payment_methode_id">
                                            @if(!empty($payment_methode))
                                            @foreach($payment_methode as $row)
                                            <option value="{{$row->id}}" @if(isset($data))@if($data->
                                                manager_id == $row->id) selected @endif @endif >From
                                                {{$row->name}}
                                            </option>

                                            @endforeach
                                            @endif
                                        </select>

                                    </div>
                                </div>

                                <div class="form-group row"><label class="col-lg-2 col-form-label">Notes</label>

                                    <div class="col-lg-10">
                                        <input type="text" name="notes" value="{{ isset($data) ? $data->amount-$data->due_amount : ''}}"
                                            class="form-control" @if(empty($data)) disabled @endif>
                                    </div>
                                </div>








                                <div class="form-group row">
                                    <div class="col-lg-offset-2 col-lg-12">
                                        @if(!@empty($id))
                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs" data-toggle="modal"
                                            data-target="#myModal" type="submit">Update</button>
                                        @else
                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs" type="submit">Add
                                            Payments</button>
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
</section>



@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('.dataTables-example').DataTable({
        pageLength: 25,
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: [{
                extend: 'copy'
            },
            {
                extend: 'csv'
            },
            {
                extend: 'excel',
                title: 'ExampleFile'
            },
            {
                extend: 'pdf',
                title: 'ExampleFile'
            },

            {
                extend: 'print',
                customize: function(win) {
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            }
        ]

    });

});
</script>
<script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>

@endsection