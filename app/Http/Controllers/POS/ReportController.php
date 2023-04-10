<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Models\AccountCodes;
use App\Models\Currency;
use App\Models\Inventory;
use App\Models\InventoryHistory;
use App\Models\POS\InvoicePayments;
use App\Models\POS\InvoiceHistory;
use App\Models\POS\PurchaseHistory;
use App\Models\POS\Items;
use App\Models\JournalEntry;
use App\Models\Location;
use App\Models\Payment_methodes;
//use App\Models\invoice_items;
use App\Models\Client;
use App\Models\InventoryList;
use App\Models\ServiceType;
use App\Models\POS\Invoice;
use App\Models\POS\InvoiceItems;
use App\Models\User;
use PDF;


use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
  public function __construct()
    {
        $this->middleware('auth');
    }

    

public function purchase_report(Request $request)
    {
       
$data=Items::where('added_by',auth()->user()->added_by)->where('quantity','>', '0')->get();
     $start_date = $request->start_date;
        $end_date = $request->end_date;    

        return view('pos.report.purchase_report',
             compact('data','start_date','end_date'));
    
    }

    public function production_report(Request $request)
    {
       
$data=Items::where('added_by',auth()->user()->added_by)->where('quantity','>', '0')->get();
     $start_date = $request->start_date;
        $end_date = $request->end_date;    

        return view('pos.report.production_report',
             compact('data','start_date','end_date'));
    
    }

public function good_issue_report(Request $request)
    {
       
$data=Items::where('added_by',auth()->user()->added_by)->where('quantity','>', '0')->get();
       $start_date = $request->start_date;
        $end_date = $request->end_date;  

        return view('pos.report.good_issue_report',
              compact('data','start_date','end_date'));
    
    }

public function sales_report(Request $request)
    {
       
$data=Items::where('added_by',auth()->user()->added_by)->where('quantity','>', '0')->get();
      $start_date = $request->start_date;
        $end_date = $request->end_date;   

        return view('pos.report.sales_report',
              compact('data','start_date','end_date'));
    
    }
public function balance_report(Request $request)
    {
       
$data=Items::where('added_by',auth()->user()->added_by)->where('quantity','>', '0')->get();
     

        return view('pos.report.balance_report',
            compact('data'));
    
    }


public function stock_report(Request $request)
    {
    
     $start_date = $request->start_date;
        $end_date = $request->end_date;  
$data=Items::where('added_by',auth()->user()->added_by)->where('quantity','>', '0')->get();
     

        return view('pos.report.stock_report',
          compact('data','start_date','end_date'));
    
    }

public function report_by_date(Request $request)
    {
    
     $start_date = $request->start_date;
        $end_date = $request->end_date;  
$data=Items::where('added_by',auth()->user()->added_by)->where('quantity','>', '0')->get();
     

        return view('pos.report.report_by_date',
          compact('data','start_date','end_date'));
    
    }

public function profit_report(Request $request)
    {
    
     $start_date = $request->start_date;
        $end_date = $request->end_date;  
$data=Items::where('added_by',auth()->user()->added_by)->where('quantity','>', '0')->get();
     

        return view('pos.report.profit_report',
          compact('data','start_date','end_date'));
    
    }


}
