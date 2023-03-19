@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-5">
                <div class="card row">
                    <div class="card-header">
                        <h4>Purchases Tyre Amount</h4>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>

                                <tr>

                                    <th scope="col">Ref No</th>
                                    <th scope="col">Due Amount</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($invoice))
                      
                                <tr>


                                    <td><a href="{{ route('purchase_tyre.show',$invoice->id)}}">{{ $invoice->reference_no}}
                                            </a></td>
                                    <td>{{ $invoice->due_amount}} {{$invoice->exchange_code}} </td>
                                    <td> 
                                        @if($invoice->status == 1)
                                        <div class="badge badge-warning badge-shadow">Not Paid</div>
                                        @elseif($invoice->status == 2)
                                        <div class="badge badge-info badge-shadow">Partially Paid</div>
                                        @elseif($invoice->status == 3)
                                        <span class="badge badge-success badge-shadow">Fully Paid</span>
                                       
                                        @endif
                                       
                                    </td>


                                </tr>
                                
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
            <div class="col-12 col-sm-6 col-lg-7">
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
                                {{ Form::model($id, array('route' => array('tyre_payment.update', $id), 'method' => 'PUT')) }}
                                @else
                                {{ Form::open(['route' => 'tyre_payment.store']) }}
                                @method('POST')
                                @endif


                                <div class="form-group row">

                                    <label class="col-lg-2 col-form-label">Amount
                                    </label>
                                    <div class="col-lg-10">
                                        <input type="number" name="amount" step="0.01"
                                            value="{{ $data->amount}}" class="form-control">

                                            <input type="hidden" name="purchase_id"
                                            value="{{ $data->purchase_id }}" class="form-control">
                                    </div>
                                </div>


                                <div class="form-group row"><label class="col-lg-2 col-form-label">Payment Date</label>

                                    <div class="col-lg-10">
                                        <input type="date" name="date" value="{{ isset($data) ? $data->date : date('d/m/y')}}"
                                            class="form-control" required>
                                    </div>
                                </div>

                                <div class="form-group row"><label class="col-lg-2 col-form-label">Payment
                                        Method</label>

                                    <div class="col-lg-10">
                                        <select class="form-control m-b" name="payment_method">
                                            <option value="">Select
                                            </option>
                                            @if(!empty($payment_method))
                                            @foreach($payment_method as $row)
                                            <option value="{{$row->id}}" @if(isset($data))@if($data->
                                                payment_method == $row->id) selected @endif @endif >From
                                                {{$row->name}}
                                            </option>

                                            @endforeach
                                            @endif
                                        </select>

                                    </div>
                                </div>

                                <div class="form-group row"><label class="col-lg-2 col-form-label">Notes</label>

                                    <div class="col-lg-10">
                                        <textarea name="notes" 
                                            class="form-control">{{ $data->notes }}</textarea>
                                    </div>
                                </div>




                                <div class="form-group row"><label  class="col-lg-2 col-form-label">Bank/Cash Account</label>

                                    <div class="col-lg-10">
                                       <select class="form-control" name="account_id" required>
                                    <option value="">Select Payment Account</option> 
                                          @foreach ($bank_accounts as $bank)                                                             
                                            <option value="{{$bank->id}}" @if(isset($data))@if($data->account_id == $bank->id) selected @endif @endif >{{$bank->account_name}}</option>
                                               @endforeach
                                              </select>
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