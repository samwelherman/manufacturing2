<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JournalEntry;
use App\Models\ClassAccount;
use App\Models\GroupAccount;
use App\Models\AccountCodes;
use App\Models\District;
use App\Models\Cotton\PurchaseCotton;
use App\Models\Cotton\CollectionCenter;
use App\Models\Cotton\ProductionActivity;
use App\Models\Cotton\Costants;
use App\Models\Cotton\CottonMovement;
use App\Models\Deposit;
use App\Models\Expenses;
use App\Models\Truck;
use App\Models\Client;
use App\Models\Mileage;
use App\Models\Pacel\PacelInvoice;
use App\Models\Fuel\Fuel;
use App\Models\Permit\Permit;
use App\Models\Tyre\Tyre;
use App\Models\CargoCollection;
use App\Models\CargoLoading;
use App\Models\Courier\CourierInvoice;
use App\Models\Courier\CourierLoading;
use App\Models\Courier\CourierCollection;
use App\Models\Courier\CourierClient;
use App\Models\Driver;
use App\Models\POS\Invoice;
use App\Models\POS\Purchase;
use App\Models\Payroll\SalaryPayment;
use App\Models\Pharmacy\Purchase as PharPurchase;
use App\Models\Pharmacy\Invoice as PharInvoice;
use App\Models\Pharmacy\Items as PharItems;
use App\Models\Pharmacy\Supplier as PharSupplier;
use App\Models\Pharmacy\Client as PharClient;
use App\Models\POS\Items ;
use App\Models\Supplier;
use App\Models\School\School;
use App\Models\School\Student;
use App\Models\School\StudentPayment;
use App\Models\School\SchoolPayment;
use App\Models\Project\Milestone;
use App\Models\Project\Task;
use App\Models\Project\Project;
use App\Models\User;
use App\Models\System;
use DateTime;
use Carbon\Carbon;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {



        //transaction
         $data['deposit'] = Deposit::where('added_by',auth()->user()->added_by)->sum('amount');
         $data['expense'] =Expenses::where('multiple','0')->where('added_by',auth()->user()->added_by)->sum('amount');

     
      //pos
      $data['pos_invoice'] = Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->whereYear('invoice_date', date('Y'))->sum(\DB::raw('(invoice_amount + invoice_tax) * exchange_rate'));
         $data['pos_due'] = Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->whereYear('invoice_date', date('Y'))->sum(\DB::raw('due_amount * exchange_rate')); 
       $data['pos_supplier'] = Supplier::where('user_id',auth()->user()->added_by)->count();
          $data['pos_item'] = Items::where('added_by',auth()->user()->added_by)->count();
         $data['pos_client'] = Client::where('user_id',auth()->user()->added_by)->count();      



   

          //school
       
        
          
             




    $settings= System::where('added_by',auth()->user()->added_by)->first();
    
    $user_type = User::find(auth()->user()->id)->user_type;

if($user_type == 'affiliate'){
    return view('agrihub.affiliate_dashboard');
}
else{
    
    if(!empty($settings)){
    return view('agrihub.dashboard',$data);
    }
    else{
        
        return view('agrihub.dashboard23');
    }

}





        
        
    }


}
