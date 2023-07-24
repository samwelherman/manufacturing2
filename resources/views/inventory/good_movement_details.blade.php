@extends('layouts.master')
<style>
    .p-md {
        padding: 12px !important;
    }

    .bg-items {
        background: #303252;
        color: #ffffff;
    }

    .ml-13 {
        margin-left: -13px !important;
    }
</style>

@section('content')
    <section class="section">
        <div class="section-body">


            <div class="row">


                <div class="col-12 col-md-12 col-lg-12">

                    <div class="col-lg-10">
                        @if ($purchases->good_receive == 0 && $purchases->status != 4)
                            <a class="btn btn-xs btn-primary" onclick="return confirm('Are you sure?')"
                                href="{{ route('good_movement.edit', $purchases->id) }}" title=""> Edit </a>
                        @endif

                        @if ($purchases->status == 0)
                        @can('approve-movement')
                            <a class="btn btn-xs btn-info" title="Convert to Invoice"
                                onclick="return confirm('Are you sure?')"
                                href="{{ route('good_movement.approve', $purchases->id) }}" title="">Approve  </a>
                       
                        @endcan      
                          @endif
                   

                      


                        <a class="btn btn-xs btn-success"
                            href="{{ route('movement_pdfview', ['download' => 'pdf', 'id' => $purchases->id]) }}" title="">
                            Download PDF </a>

                    </div>

                    <br>

       

                    

                    <div class="card">
                        <div class="card-body">

                            <?php
                            $settings = App\Models\System::where('added_by', auth()->user()->added_by)->first();
                            
                            ?>
                            <div class="tab-content" id="myTab3Content">
                                <div class="tab-pane fade show active" id="about" role="tabpanel"
                                    aria-labelledby="home-tab2">
                                    <div class="row">
                                        <div class="col-lg-6 col-xs-6 ">
                                            <img class="pl-lg" style="width: 233px;height: 120px;"
                                                src="{{ url('assets/img/logo') }}/{{ $settings->picture }}">
                                        </div>

                                        <div class="col-lg-3 col-xs-3">

                                        </div>

                                        <div class="col-lg-3 col-xs-3">

                                            <h5 class=mb0">REF NO : {{ $purchases->reference_no }}</h5>
                                             Date :
                                            {{ Carbon\Carbon::parse($purchases->date)->format('d/m/Y') }}
                                            

                                            <br>Status:
                                            @if ($purchases->status == 0)
                                                <span class="badge badge-danger badge-shadow">Not Approved</span>
                                           
                                            @elseif($purchases->status == 1)
                                                <span class="badge badge-success badge-shadow">Approved</span>
                                            @elseif($purchases->status == 2)
                                                <span class="badge badge-danger badge-shadow">Cancelled</span>
                                            @endif

                                        



                                        </div>
                                    </div>



                                    <div class="row mb-lg">
                                        <div class="col-lg-6 col-xs-6">
                                            <h5 class="p-md bg-items mr-15">Our Info:</h5>
                                            <h4 class="mb0">{{ $settings->name }}</h4>
                                            {{ $settings->address }}
                                            <br>Phone : {{ $settings->phone }}
                                            <br> Email : <a
                                                href="mailto:{{ $settings->email }}">{{ $settings->email }}</a>
                                            <br>TIN : {{ $settings->tin }}
                                        </div>


                                        <div class="col-lg-6 col-xs-6">
                                            <h4 class="p-md bg-items mr-15">.</h4>
                                            <h4 class="mb0">Source Location: {{ $purchases->source->name }}</h4>
                                            
                                            <h5 class="mb0">Destination Location: {{ $purchases->destination->name }}</h5>
                                         

                                        </div>
                                    </div>

                                </div>
                            </div>


                            <?php
                            
                            $sub_total = 0;
                            $gland_total = 0;
                            $tax = 0;
                            $i = 1;
                            
                            ?>

                            <div class="table-responsive mb-lg">
                                <table class="table items invoice-items-preview" page-break-inside:="" auto;="">
                                    <thead class="bg-items">
                                        <tr>
                                            <th style="color:white;">#</th>
                                            <th style="color:white;">Items</th>
                                         
                                            <th style="color:white;">Qty</th>
                                            {{-- <th style="color:white;">Unit</th> --}}
                                          
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($items))
                                            @foreach ($items as $row)
                                             
                                                <tr>
                                                    <td class="">{{ $i++ }}</td>
                                                    <?php
                                                    $item_name = App\Models\POS\Items::find($row->item_id);
                                                    ?>
                                                    <td class=""><strong
                                                            class="block">{{ $item_name->name }}</strong></td>
                                                    <td class="">{{ $row->quantity }} </td>
                                                    {{-- <td class="">{{ $row->unit }} </td> --}}
                                                    
                                                   

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




            @if (!empty($payments[0]))
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="padding-20">
                            <br>
                            <h5 class="mb0" style="text-align:center">PAYMENT DETAILS</h5>
                            <div class="tab-content" id="myTab3Content">
                                <div class="tab-pane fade show active" id="about" role="tabpanel"
                                    aria-labelledby="home-tab2">
                                    <div class="row">


                                        <?php
                                        
                                        $i = 1;
                                        
                                        ?>
                                        <div class="table-responsive">
                                            <table class="table datatable-basic table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Transaction ID</th>
                                                        <th>Payment Date</th>
                                                        <th>Amount</th>
                                                        <th>Payment Mode</th>
                                                        <th>Payment Account</th>
                                                        <!--<th>Action</th>-->
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach ($payments as $row)
                                                        <tr>
                                                            <?php
                                                            $method = App\Models\Payment_methodes::find($row->payment_method);
                                                            
                                                            ?>
                                                            <td class=""> {{ $row->trans_id }}</td>
                                                            <td class="">
                                                                {{ Carbon\Carbon::parse($row->date)->format('d/m/Y') }}
                                                            </td>
                                                            <td class="">{{ number_format($row->amount, 2) }}
                                                                {{ $purchases->currency_code }}</td>
                                                            <td class="">{{ $method->name }}</td>
                                                            <td class="">{{ $row->payment->account_name }}</td>
                                                            <!--<td class=""><a class="btn btn-xs btn-outline-info text-uppercase px-2 rounded"
                                                title="Edit" onclick="return confirm('Are you sure?')"
                                                href="{{ route('tyre_payment.edit', $row->id) }}"><i
                                                    class="fa fa-edit"></i></a></td>-->
                                                        </tr>
                                                    @endforeach



                                                </tbody>

                                            </table>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
            @endif
        </div>
        </div>
    </section>



@endsection

@section('scripts')
    <script>
        $('.datatable-basic').DataTable({
            autoWidth: false,
            "columnDefs": [{
                "orderable": false,
                "targets": [3]
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
@endsection
