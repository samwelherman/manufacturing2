<!DOCTYPE html>
<html>

<head>
    <title>Download PDF </title>
</head>
<style type="text/css">
    body {
        font-family: 'Roboto Condensed', sans-serif;
    }

    .m-0 {
        margin: 0px;
    }

    .p-0 {
        padding: 0px;
    }

    .pt-5 {
        padding-top: 5px;
    }

    .mt-10 {
        margin-top: 10px;
    }

    .text-center {
        text-align: center !important;
    }

    .w-100 {
        width: 100%;
    }

    .w-85 {
        width: 85%;
    }

    .w-15 {
        width: 15%;
    }

    .logo img {
        width: 45px;
        height: 45px;
        padding-top: 30px;
    }

    .logo span {
        margin-left: 8px;
        top: 19px;
        position: absolute;
        font-weight: bold;
        font-size: 25px;
    }

    .gray-color {
        color: #5D5D5D;
    }

    .text-bold {
        font-weight: bold;
    }

    .border {
        border: 1px solid black;
    }

    table tbody tr,
    table thead th,
    table tbody td {
        border: 1px solid #d2d2d2;
        border-collapse: collapse;
        padding: 7px 8px;
    }

    table tr th {
        background: #F4F4F4;
        font-size: 15px;
    }

    table tr td {
        font-size: 13px;
    }

    table {
        border-collapse: collapse;
    }

    .box-text p {
        line-height: 10px;
    }

    .float-left {
        float: left;
    }

    .total-part {
        font-size: 16px;
        line-height: 12px;
    }

    .total-right p {
        padding-right: 30px;
    }

    footer {
        color: #777777;
        width: 100%;
        height: 30px;
        position: absolute;
        bottom: -20px;
        border-top: 1px solid #aaaaaa;
        padding: 8px 0;
        text-align: center;
    }

    table tfoot tr:first-child td {
        border-top: none;
    }

    table tfoot tr td {
        padding: 7px 8px;
    }


    table tfoot tr td:first-child {
        border: none;
    }
</style>

<body>
    <?php
    $settings = App\Models\System::where('added_by', auth()->user()->added_by)->first();
    $items = App\Models\SystemDetails::where('system_id', $settings->id)->get();
    ?>
    <div class="head-title">
        <h5 class="text-center m-0 p-0">Movement Order<br>
            <img class="pl-lg text-center" style="width: 150px;height: 100px; align: center;"
            src="{{ url('assets/img/logo') }}/{{ $settings->picture }}">
        </h5>
    </div>
    <div class="head-title">
       
       
    </div>


    <div class="add-detail ">
        <table class="table w-100 ">
            <tfoot>

                <tr>
                    <td class="w-50">
                        
                    </td>

                    <td>
                        <div class="box-text"> </div>
                    </td>
                    <td>
                        <div class="box-text"> </div>
                    </td>
                    <td>
                        <div class="box-text"> </div>
                    </td>
                    <td>
                        <div class="box-text"> </div>
                    </td>
                    <td>
                         <div class="box-text">
                            
                        </div>
                    </td>

                    <td class="w-50">
                        <div class="box-text">
                            
                            
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>


        <div style="clear: both;"></div>
    </div>

    <div class="table-section bill-tbl w-100 mt-10">
        <table class="table w-100 mt-10">
            <tbody>
                <tr>
                    <th class="w-50">Our Info</th>
                    <th class="w-50">.</th>
                </tr>
                <tr>
                    <td>
                        <div class="box-text">
                            <p>{{ $settings->name }}</p>
                            <p>{{ $settings->address }}</p>
                            <p>Contact :{{ $settings->phone }}</p>
                            <p>Email: <a href="mailto:{{ $settings->email }}">{{ $settings->email }}</p>
                            <p>TIN : {{ $settings->tin }}</p>
                        </div>
                    </td>
                    <td>
                        <div class="box-text">
                            <p> <strong>Date :
                                {{ Carbon\Carbon::parse($purchases->date)->format('d/m/Y') }}</strong></p>
                            <p> <strong>Reference: {{ $purchases->reference_no }}</strong></p>
                            <p class="mb0">Source Location: {{ $purchases->source->name }}</p>

                            <p class="mb0">Destination Location: {{ $purchases->destination->name }}</p>


                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>


    <?php
    
    $sub_total = 0;
    $gland_total = 0;
    $tax = 0;
    $i = 1;
    
    ?>

    <div class="table-section bill-tbl w-100 mt-10">
        <table class="table w-100 mt-10">
            <thead>
                <tr>
                    <th class="">#</th>
                    <th class="">Items</th>

                    <th class="">Qty</th>

                </tr>
            </thead>
            <tbody>
                @if (!empty($mov_items))
                    @foreach($mov_items as $row)
                        <tr>
                            <td class="">{{ $i++ }}</td>
                            <?php
                            $item_name = App\Models\POS\Items::find($row->item_id);
                            ?>
                            <td class="">{{ $item_name->name }}</td>
                            <td class="">{{ $row->quantity }} </td>
                            



                        </tr>
                    @endforeach
                @endif
            </tbody>

            <tfoot>
          



            </tfoot>
        </table>

        <br><br><br>




        <table class="table w-100 mt-20">


        </table>
    </div>

    <footer>
        This is a computer generated
    </footer>
</body>

</html>
