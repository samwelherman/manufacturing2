@extends('layouts.master')
<style>
    .p-md {
        padding: 12px !important;
    }

    .bg-items {
        background: #7c7fa7;
        color: #0e0d0d;
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






                        <a class="btn btn-xs btn-success"
                            href="{{ route('work_order_pdfview', ['download' => 'pdf','type'=>'work_order', 'id' => $purchases->id]) }}" title="">
                            Download PDF </a>

                    </div>

                    <br>

    

                    <br>

                    <div class="card">
                        <div class="padding-20">

                            <?php
                            $settings = App\Models\System::first();
                            
                            ?>
                            <div class="tab-content" id="myTab3Content">
                                <div class="tab-pane fade show active" id="about" role="tabpanel"
                                    aria-labelledby="home-tab2">
                                    <div class="row">
                                        <div class="col-lg-6 col-xs-6 ">
                                            <img class="pl-lg" style="width: 233px;height: 120px;"
                                                src="{{ url('public/assets/img/logo') }}/{{ $settings->picture }}">
                                        </div>

                                        <div class="col-lg-3 col-xs-3">

                                        </div>

                                        <div class="col-lg-3 col-xs-3">







                                        </div>
                                    </div>


                                    <br><br>
                                    <div class="row mb-lg">
                                       


                                       
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
                                            <td colspan="9" style="text-align: center;">TIGER PLASTC INDUSTRY <br><br>PRODUCTION ORDER</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="text-align: center;">DATE:</td>

                                            <td colspan="5" style="text-align:right;"></td>
                                            <td colspan="2" style="text-align: center;">CLIENT:</td>

                                        </tr>
                                        <tr>
                                            <th style="">S/N</th>
                                            <th style="">QTY/M</th>
                                            <th style="">ITEM</th>
                                            <th style="">KG/M</th>
                                            <th  style="">TOTAL MATERIAL</th>
                                            <th  style="">RECY(KG)</th>
                                            <th  style="">FRESH(KG)</th>
                                            <th  style="">METER/PCS</th>
                                            <th  style="">TOTAL PCS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $total_qty = 0;
                                            $total_material = 0;
                                            $total_recycle = 0;
                                            $total_fresh = 0;
                                            $total_m_C = 0;
                                            $total_pc =0;
                                        @endphp
                                        @if (!empty($items))
                                            @foreach ($items as $row)

                                            @php
                                           $data = App\Models\Manufacturing\BillOFMaterialInventory::where('bill_of_material_id',$row->bill_of_material->id)->sum('quantity');
           
                                            $total_qty = 0;
                                            $total_material += $data*$row->quantity;
                                            $total_recycle += ($data*$row->quantity)/2;
                                            $total_fresh += ($data*$row->quantity)/2;
                                            $total_m_c = $row->length;
                                            $total_pc +=$row->quantity;
                                        @endphp
                                            <tr>
                                                <td style="">{{ $row->iteration }}</td>
                                                <td style="">QTY/M</td>
                                                <td style="">{{ $row->item->name }}</td>
                                                <td style="">{{ $row->item->kg_m }}</td>
                                                @php
                                                @endphp
                                                <td  style="">{{ $data*$row->quantity }}</td>
                                                <td  style="">{{ ($data/2)*$row->quantity }}</td>
                                                <td  style="">{{ ($data/2)*$row->quantity }}</td>
                                                <td  style="">{{ $row->lenght }}</td>
                                                <td  style="">{{ $row->quantity }}</td>
                                            </tr>
                                            <tr><td colspan="9" style="text-align: center; font-weight:600;">{{ $row->unit }}</td></tr>
                                            @endforeach
                                            <tr>
                                                <tr style="font-weight:500;">
                                                    <td style="">{{ $row->iteration }}</td>
                                                    <td style="">TOTAL</td>
                                                    <td style=""></td>
                                                    <td style=""></td>
                                                
                                                    <td  style="">{{ $total_material }}</td>
                                                    <td  style="">{{ $total_recycle }}</td>
                                                    <td  style="">{{ $total_fresh }}</td>
                                                    <td  style="">{{ $total_m_c }}</td>
                                                    <td  style="">{{ $total_pc }}</td>
                                                </tr> 
                                            </tr>
                                        @endif


                                    </tbody>
                                </table>
                            </div>
<br>
<hr>
                        <p>  <h5>ZINGATIA UBOTA PAMOJA NA PRINTING KUTOKANA NA BIDHAA HUSIKA</h5> </p>
<table>
    <tr><td>ORDER COMPLETED ON DATE____________________</td> <td>PREPARED BY________________________ <br>CONFIRMED BY___________________________</td></tr>
</table>
                        </div>

                    </div>
                </div>
            </div>



          
        </div>
        </div>
    </section>



@endsection

@section('scripts')
@endsection
