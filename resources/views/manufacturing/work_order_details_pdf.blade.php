<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Tire</title>

    <style type="text/css">
        /*@page {*/
        /*    margin: 1in 0in 0in 0in;*/
        /*}*/
        @font-face {
            font-family: "Source Sans Pro", sans-serif;
        }

        .h4 {
            font-size: 14px;
        }

        .h3 {
            font-size: 15px;
        }

        h2 {
            font-size: 19px;
        }

        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        a {
            color: #0087C3;
            text-decoration: none;
        }

        body {
            color: #555555;
            background: #ffffff;
            font-size: 12px;
            font-family: "Source Sans Pro", sans-serif;
            width: 100%;

        }

        header {
            padding: 10px 0;
            margin-bottom: 15px;
            border-bottom: 1px solid #aaaaaa;

        }

        #logo {}

        #company {
            text-align: right;

        }

        #details {
            margin-bottom: 10px;

        }

        #client {
            padding-left: 6px;
            /*border-left: 6px solid #0087C3;*/

        }

        #client .to {
            color: #777777;
        }

        h2.name {
            font-size: 1em;
            font-weight: normal;
            margin: 0;

        }

        #invoice {
            text-align: right;

        }

        #invoice h1 {
            color: #0087C3;
            font-size: 1.5em;
            line-height: 1em;
            font-weight: normal;

        }

        #invoice .date {
            font-size: 1.1em;
            color: #777777;

        }

        table {
            width: 100%;
            border-spacing: 0;

        }

        table.items {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            /*margin-bottom: 10px;*/

        }
/* 
        table.items th,
        table.items td {
            padding: 5px;
            /*background: #EEEEEE;*/
            /* border-bottom: 2px solid #FFFFFF;
            text-align: left; */


       /* } */

        table.items th {
            white-space: nowrap;
            font-weight: normal;

        }

        table.items td {
            text-align: center;

        }

        table.items td h3 {
            color: #57B223;
            font-size: 1em;
            font-weight: normal;
            margin-top: 2px;
            margin-bottom: 2px;

        }

        table.items .no {
            background: #dddddd;
        }

        table.items .desc {
            text-align: left;

        }

        table.items .unit {
            background: #F3F3F3;
            padding: 5px 10px 5px 5px;
            word-wrap: break-word;
        }

        table.items .qty {}

        table.items td.unit,
        table.items td.qty,
        table.items td.total {
            font-size: 1em;
        }

        table.items tbody tr:last-child td {
            border: none;

        }

        table.items tfoot td {
            padding: 5px 10px;
            background: #ffffff;
            border-bottom: none;
            font-size: 14px;
            white-space: nowrap;
            border-top: 1px solid #aaaaaa;

        }

        table.items tfoot tr:first-child td {
            border-top: none;
        }

        table.items tfoot tr:last-child td {
            color: #57B223;
            font-size: 1.4em;
            border-top: 1px solid #57B223;

        }

        table.items tfoot tr td:first-child {
            border: none;
            text-align: right;

        }

        #thanks {
            font-size: 16px;
            margin-bottom: 10px;
        }

        #notices {
            padding-left: 6px;
            border-left: 0px solid #0087C3;

        }

        #notices .notice {
            font-size: 1em;
            color: #000000;
        }

        table, th, td {
  border: 1px solid black !important;
}

        footer {
            color: #777777;
            width: 100%;
            height: 30px;
            position: absolute;
            bottom: 0;
            border-top: 1px solid #aaaaaa;
            padding: 8px 0;
            text-align: center;
        }

        tr.total td,
        tr th.total,
        tr td.total {
            text-align: right;

        }

        .bg-items {
            background: #303252 !important;
            color: #ffffff
        }

        .p-md {
            padding: 9px !important;
        }

        .left {
            float: left;

        }

        .right {
            float: right;
            padding-left: 10px;

        }

        .num_word {
            margin-top: 5px;
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    <?php
    $settings = App\Models\System::first();
    
    ?>
 




    <div id="notices">
        <div class="notice"></div>
    </div><br><br>


 

<table class="" page-break-inside:="" auto;="">
    <thead class="">
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
    <tr><td>ORDER COMPLETED ON ____________________</td> <td>PREPARED BY________________________ <br>CONFIRMED BY___________________________</td></tr>
</table>
 <p>
    <h5>RECCOMMENDATION BY PRODUCTION MANAGER</h5>
    ______________________________________________________________________________________________________________________________<br>
    ______________________________________________________________________________________________________________________________<br>
    ______________________________________________________________________________________________________________________________<br>
    ______________________________________________________________________________________________________________________________<br>
    ______________________________________________________________________________________________________________________________<br>
    ______________________________________________________________________________________________________________________________<br>
    ______________________________________________________________________________________________________________________________<br>
 </p>

    <!--
<table class="clearfix">
    <tr>
        <td style="width: 50%;">
            <div class="left" style="">
        <div><u> <h3><b> Account Details For Us-Dollar</b></h3></u> </div>
        <div><b>Account Name</b>:  Isumba Trans Ltd</div>
        <div><b>Account Number</b>:  10201632013 </div>
        <div><b>Bank Name</b>: Bank of Africa</div>
        <div><b>Branch</b>: Business Centre</div>
        <div><b>Swift Code</b>: EUAFTZ TZ</div>
        <div></div>
        </div></td>
    </tr>
      <tr>
         <td style="width: 50%;">
            <div class="right" style="">
        <div><u>  <h3><b>Account Details For Tanzania Shillings</b></h3></u> </div>
         <div><b>Account Name</b>:  Isumba Trans Ltd</div>
        <div><b>Account Number</b>:  10201632005 </div>
        <div><b>Bank Name</b>: Bank of Africa</div>
        <div><b>Branch</b>: Business Centre</div>
        <div><b>Swift Code</b>: EUAFTZ TZ</div>
          </div>
        </td>
</table>
!-->

    <footer>

    </footer>
</body>

</html>
