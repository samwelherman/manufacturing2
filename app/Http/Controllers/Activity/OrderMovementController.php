<?php

namespace App\Http\Controllers\Activity;

use App\Http\Controllers\Controller;
use App\Models\orders\Activity;
use App\Models\orders\Cost_function;
use App\Models\orders\OrderMovement;
use App\Models\orders\Order;
use Illuminate\Http\Request;
use App\Models\Truck;
use App\Models\Driver;
use App\Models\TruckInsurance;
use App\Models\Sticker;
use App\Models\Fuel\Fuel;
use App\Models\Mileage;
use App\Models\Route;
use App\Models\Permit\Permit;
use App\Models\Permit\PermitType;
use App\Models\Permit\PermitPayment;
use App\Models\Pacel\Pacel;
use App\Models\Pacel\PacelItem;
use App\Models\Pacel\PacelInvoice;
use App\Models\Pacel\PacelInvoiceItem;
use App\Models\JournalEntry;
use App\Models\AccountCodes;
use App\Models\Client;
use App\Models\Region;
use App\Models\User;
use App\Models\CargoLoading;
use App\Models\CargoCollection;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\ButtonsServiceProvider;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class OrderMovementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

 public function findTruck(Request $request)
    {

       $collect=CargoCollection::find($request->collection);
     $data['id']=$request->collection;
               $data['truck']= Truck::where('truck_status','Available')->where('location',$collect->from_region_id)->where('truck_type','!=','Trailer')->where('type',$request->id)->where('disabled','0')->where('added_by',auth()->user()->added_by)->get(); 
                 $data['driver']=Driver::where('available','1')->where('type',$request->id)->where('added_by',auth()->user()->added_by)->get();   
                return response()->json(['html' => view('order_movement.addtruck', $data)->render()]);     

       

}

  public function findDriver(Request $request)
    {

               $truck=Truck::find($request->id);
                 if(!empty($truck->driver)){
               $driver=Driver::find($truck->driver);
               
                   
}      

else{
            $driver='Please Assign Driver to the Truck.';
}

   return response()->json($driver);     
    }

    public function show($id,Request $request)
    {
        //
        switch ($request->type) {
            case 'collection':
           $collect=CargoCollection::find($id);
               $truck = Truck::where('truck_status','Available')->where('location',$collect->from_region_id)->where('truck_type','!=','Trailer')->where('added_by',auth()->user()->added_by)->get(); 
                 $driver =Driver::where('available','1')->where('added_by',auth()->user()->added_by)->get(); 
                    return view('order_movement.addcollection',compact('id','truck','driver'));
                    break;
            case 'loading':
                        return view('order_movement.addloading',compact('id'));
                        break;
            case 'offloading':
                            return view('order_movement.addoffloading',compact('id'));
                            break;
            case 'delivering':
                                return view('order_movement.adddelivering',compact('id'));
                                break;
              case 'fuel':
                        return view('order_movement.addfuel',compact('id'));
                        break;
             
             default:
             return abort(404);
             
            }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    public function collection(){
        $user_id=auth()->user()->added_by;
       
          $quotation = CargoCollection::where('added_by', auth()->user()->added_by)->where('status','2')->get();
        $costs = Cost_function::all()->where('user_id',$user_id);

        return view('order_movement.collection',compact('quotation','costs'));

    }

    public function loading(){
        $user_id=auth()->user()->added_by;
        $quotation = CargoLoading::where('added_by', auth()->user()->added_by)->where('status','3')->get();
        $costs = Cost_function::all()->where('user_id',$user_id);

        return view('order_movement.loading',compact('quotation','costs'));

    }

    public function offloading(){
        $user_id=auth()->user()->added_by;
        $quotation = CargoLoading::where('added_by', auth()->user()->added_by)->where('status','4')->get();
        $costs = Cost_function::all()->where('user_id',$user_id);
       
        return view('order_movement.offloading',compact('quotation','costs'));

    }

    public function delivering(){
        $user_id=auth()->user()->added_by;
        $quotation = CargoLoading::where('added_by', auth()->user()->added_by)->where('status','5')->orwhere('status','6')->get();
        $costs = Cost_function::all()->where('user_id',$user_id);

        return view('order_movement.delivering',compact('quotation','costs'));

    }
   public function return(){
        $truck = Truck::where('truck_status','Available')->where('truck_type','!=','Trailer')->where('disabled','0')->get();  
         $driver = Driver::all(); 
        $route=Route::all();    
      $region = Region::all();   
       $id=1;
        return view('order_movement.fuel',compact('region','route','driver','truck','id'));

    }

      public function wb(){
        $user_id=auth()->user()->added_by;
       
          $quotation = CargoCollection::where('added_by', auth()->user()->added_by)->where('status','4')->get();
        $costs = Cost_function::all()->where('user_id',$user_id);

        return view('order_movement.wb',compact('quotation','costs'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        switch ($request->type) {
            case 'collection':

                $movement=CargoCollection::find($id);
                $truck=Truck::where('id',$request->truck_id)->first();
             $driver=Driver::find($request->driver_id);

//$loading=CargoLoading::where('status','!=', 6)->where('truck_id', $request->truck_id)->sum('weight');

$truck->update(['truck_status'=>'Unavailable']);

if(!empty($truck->connect_horse=='1')){
$trailer=Truck::find($truck->connect_trailer);
$trailer->update(['truck_status'=>'Unavailable']);
}

    
$driver->update(['available'=>'0']);

                    $loading_cargo =CargoLoading::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
                            'truck_id'=>$request->truck_id,
                            'driver_id'=>$request->driver_id,
                            'type'=>$request->owner_type,
                            'weight'=>$movement->weight,
                          'quantity'=>$movement->quantity,
                           'total_weight'=>$movement->weight,
                            'status'=>'3',
                        'fuel'=>'0',
                           'pacel_id'=>$movement->pacel_id,
                           'pacel_name'=>$movement->pacel_name,
                         'pacel_number'=>$movement->pacel_number,
                         'start_location'=> $movement->start_location,
                         'end_location'=>$movement->end_location,
                         'from_region_id'=> $movement->from_region_id,
                         'to_region_id'=>$movement->to_region_id,
                             'end'=>$request->end,
                         'item_id'=>$movement->item_id,
                        'owner_id'=>$movement->owner_id,
                       'collection_id'=>$id,
                       'receiver_name'=>$movement->receiver_name,
                        'amount'=>$movement->amount,
                        'route_id'=>$movement->route_id,
                       'collection_date'=>$request->collection_date,
                       'receipt'=>$request->receipt,
                        ]
                        );                      
      



                 
                if(!empty($loading_cargo)){
                    $activity = Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
                            'module_id'=>$movement->pacel_id,
                            'module'=>'Cargo',
                            'activity'=>"Confirm Collection",
                            'notes'=>$request->notes,
                          'loading_id'=>$loading_cargo->id,
                           'date'=>$request->collection_date,
                        ]
                        );                      
       }

              
   $data['status']='3';
    $data['end']=$request->end;
    $data['truck_id']=$request->truck_id;
     $data['driver_id']=$request->driver_id;

 $user_id=auth()->user()->added_by;
  $quotation = CargoLoading::where('added_by', auth()->user()->added_by)->where('status','3')->get();
   $costs = Cost_function::all()->where('user_id',$user_id);

$result=$movement->update($data);

  return redirect(route('order.loading'))->with(['quotation'=> $quotation,'costs'=>$costs,'success'=>'Collected Successfully']);



                    break;


                   case 'fuel':
                        $movement=CargoLoading::find($id);
                         $toll['fuel']='1';
                        $toll['road_toll']=$request->road_toll;
                         $toll['toll_gate']=$request->toll_gate;
                         $toll['council']=$request->council;
                        $toll['consultant']=$request->consultant;
                        $result=$movement->update($toll);
                         
                                                               
       $route = Route::find($movement->route_id); 
   $name=$movement->pacel_name;


       $data['route_id']=$movement->route_id;
        $data['fuel_used']=$request->fuel;
        $data['due_fuel']=$request->fuel;
       $data['date']=$request->date;
        $data['added_by']=auth()->user()->added_by;
        $data['driver_id']=$movement->driver_id;
      $data['truck_id']=$movement->truck_id;
    $data['movement_id']=$movement->id;
 $data['status_approve']='0';
        $fuel= Fuel::create($data);


  $items['route_id']=$movement->route_id;
   $items['fuel_rate']=$request->mileage;
    $items['date']=$request->date;
      $items['total_mileage']= $request->mileage;
       $items['due_mileage']=$request->mileage;
        $items['added_by']=auth()->user()->added_by;
        $items['driver_id']=$movement->driver_id;
      $items['truck_id']=$movement->truck_id;
    $items['movement_id']=$movement->id;
 $items['status_approve']='0';
$items['payment_status']='0';
        $mileage= Mileage ::create($items);

 $driver=Driver::find($movement->driver_id);
   $truck=Truck::find($movement->truck_id);
     
 $crm= AccountCodes::where('account_name','Mileage')->first();
    $journal = new JournalEntry();
  $journal->account_id = $crm->id;
 $date = explode('-',$mileage->date);
  $journal->date =   $mileage->date;
  $journal->year = $date[0];
  $journal->month = $date[1];
 $journal->transaction_type = 'mileage';
  $journal->name = 'Mileage';
  $journal->debit = $mileage->total_mileage ;
  $journal->income_id= $mileage->id;
 $journal->truck_id= $movement->truck_id;
   $journal->currency_code =  'TZS';
  $journal->exchange_rate= '1';
$journal->added_by=auth()->user()->added_by;
     $journal->notes= "Mileage of Shipment " .$name ."  to Driver  ". $driver->driver_name ." with Truck ".$truck->truck_name ;
 $journal->notes= "Mileage of Shipment " .$name ."  to Driver  ". $driver->driver_name ." with Truck ".$truck->truck_name . " - " .$truck->reg_no;
  $journal->save();


  $codes= AccountCodes::where('account_name','Payables')->first();
  $journal = new JournalEntry();
  $journal->account_id = $codes->id;
   $date = explode('-',$mileage->date);
  $journal->date =   $mileage->date;
  $journal->year = $date[0];
  $journal->month = $date[1];
   $journal->transaction_type = 'mileage';
  $journal->name = 'Mileage';
   $journal->income_id= $mileage->id;
 $journal->truck_id= $movement->truck_id;
  $journal->credit =$mileage->total_mileage ;
  $journal->currency_code =  'TZS';
  $journal->exchange_rate= '1';
$journal->added_by=auth()->user()->added_by;;
     $journal->notes= "Mileage of Shipment " .$name ."  to Driver  ". $driver->driver_name ." with Truck ".$truck->truck_name . " - " .$truck->reg_no;
  $journal->save();


 $pmt['route_id']=$movement->route_id;
   $pmt['fuel_rate']=$request->road_toll + $request->toll_gate + $request->council + $request->consultant;
    $pmt['date']=$request->date;
      $pmt['total_permit']= $request->road_toll + $request->toll_gate + $request->council + $request->consultant;;
       $pmt['due_permit']=$request->road_toll + $request->toll_gate + $request->council + $request->consultant;;
        $pmt['added_by']=auth()->user()->added_by;
        $pmt['driver_id']=$movement->driver_id;
      $pmt['truck_id']=$movement->truck_id;
    $pmt['movement_id']=$movement->id;
 $pmt['status_approve']='0';
$pmt['payment_status']='0';
        $permit= Permit ::create($pmt);

if($request->road_toll > 0){ 
                     $rpmt['route_id']=$movement->route_id;
                        $rpmt['added_by']=auth()->user()->added_by;
                        $rpmt['driver_id']=$movement->driver_id;
                        $rpmt['truck_id']=$movement->truck_id;
                       $rpmt['movement_id']=$movement->id;
                         $rpmt['value']=$request->road_toll;
                         $rpmt['type']='Road Toll';
                         $rpmt['permit_id']=$permit->id;
 $road= PermitType ::create(  $rpmt);

 $crb= AccountCodes::where('account_name','Border Permit')->first();
    $journal = new JournalEntry();
  $journal->account_id = $crb->id;
 $date = explode('-',$permit->date);
  $journal->date =   $permit->date;
  $journal->year = $date[0];
  $journal->month = $date[1];
 $journal->transaction_type = 'permit';
  $journal->name = 'Border Permit';
$journal->reference = 'Road Toll';
  $journal->debit = $request->road_toll ;
  $journal->income_id= $permit->id;
 $journal->truck_id= $movement->truck_id;
   $journal->currency_code =  'TZS';
  $journal->exchange_rate= '1';
$journal->added_by=auth()->user()->added_by;
 $journal->notes= "Road Toll of Shipment " .$name ."  to Driver  ". $driver->driver_name ." with Truck ".$truck->truck_name . " - " .$truck->reg_no;
  $journal->save();


  $codes= AccountCodes::where('account_name','Payables')->first();
  $journal = new JournalEntry();
  $journal->account_id = $codes->id;
   $date = explode('-',$permit->date);
  $journal->date =   $permit->date;
  $journal->year = $date[0];
  $journal->month = $date[1];
   $journal->transaction_type = 'permit';
  $journal->name = 'Border Permit';
$journal->reference = 'Road Toll';
   $journal->income_id= $permit->id;
 $journal->truck_id= $movement->truck_id;
  $journal->credit =$request->road_toll ;
  $journal->currency_code =  'TZS';
  $journal->exchange_rate= '1';
$journal->added_by=auth()->user()->added_by;;
   $journal->notes= "Road Toll of Shipment " .$name ."  to Driver  ". $driver->driver_name ." with Truck ".$truck->truck_name . " - " .$truck->reg_no;
  $journal->save();
}



if($request->toll_gate > 0){ 
                     $tpmt['route_id']=$movement->route_id;
                        $tpmt['added_by']=auth()->user()->added_by;
                        $tpmt['driver_id']=$movement->driver_id;
                        $tpmt['truck_id']=$movement->truck_id;
                       $tpmt['movement_id']=$movement->id;
                         $tpmt['value']=$request->toll_gate;
                         $tpmt['type']='Toll Gate';
                         $tpmt['permit_id']=$permit->id;
 $toll= PermitType ::create($tpmt);

 $crb= AccountCodes::where('account_name','Border Permit')->first();
    $journal = new JournalEntry();
  $journal->account_id = $crb->id;
 $date = explode('-',$permit->date);
  $journal->date =   $permit->date;
  $journal->year = $date[0];
  $journal->month = $date[1];
 $journal->transaction_type = 'permit';
$journal->reference = 'Toll Gate';
  $journal->name = 'Border Permit';
  $journal->debit = $request->toll_gate ;
  $journal->income_id= $permit->id;
 $journal->truck_id= $movement->truck_id;
   $journal->currency_code =  'TZS';
  $journal->exchange_rate= '1';
$journal->added_by=auth()->user()->added_by;
 $journal->notes= "Toll Gate of Shipment " .$name ."  to Driver  ". $driver->driver_name ." with Truck ".$truck->truck_name . " - " .$truck->reg_no;
  $journal->save();


  $codes= AccountCodes::where('account_name','Payables')->first();
  $journal = new JournalEntry();
  $journal->account_id = $codes->id;
   $date = explode('-',$permit->date);
  $journal->date =   $permit->date;
  $journal->year = $date[0];
  $journal->month = $date[1];
   $journal->transaction_type = 'permit';
  $journal->reference = 'Toll Gate';
  $journal->name = 'Border Permit';
   $journal->income_id= $permit->id;
 $journal->truck_id= $movement->truck_id;
  $journal->credit =$request->toll_gate;
  $journal->currency_code =  'TZS';
  $journal->exchange_rate= '1';
$journal->added_by=auth()->user()->added_by;;
   $journal->notes= "Toll Gate of Shipment " .$name ."  to Driver  ". $driver->driver_name ." with Truck ".$truck->truck_name . " - " .$truck->reg_no;
  $journal->save();
}


if($request->council > 0){ 
                     $cpmt['route_id']=$movement->route_id;
                        $cpmt['added_by']=auth()->user()->added_by;
                        $cpmt['driver_id']=$movement->driver_id;
                        $cpmt['truck_id']=$movement->truck_id;
                       $cpmt['movement_id']=$movement->id;
                         $cpmt['value']=$request->council;
                         $cpmt['type']='Council';
                         $cpmt['permit_id']=$permit->id;
 $council= PermitType ::create($cpmt);

 $crb= AccountCodes::where('account_name','Border Permit')->first();
    $journal = new JournalEntry();
  $journal->account_id = $crb->id;
 $date = explode('-',$permit->date);
  $journal->date =   $permit->date;
  $journal->year = $date[0];
  $journal->month = $date[1];
 $journal->transaction_type = 'permit';
  $journal->name = 'Border Permit';
  $journal->reference = 'Council';
  $journal->debit = $request->council ;
  $journal->income_id= $permit->id;
 $journal->truck_id= $movement->truck_id;
   $journal->currency_code =  'TZS';
  $journal->exchange_rate= '1';
$journal->added_by=auth()->user()->added_by;
 $journal->notes= "Council of Shipment " .$name ."  to Driver  ". $driver->driver_name ." with Truck ".$truck->truck_name . " - " .$truck->reg_no;
  $journal->save();


  $codes= AccountCodes::where('account_name','Payables')->first();
  $journal = new JournalEntry();
  $journal->account_id = $codes->id;
   $date = explode('-',$permit->date);
  $journal->date =   $permit->date;
  $journal->year = $date[0];
  $journal->month = $date[1];
   $journal->transaction_type = 'permit';
  $journal->name = 'Border Permit';
    $journal->reference = 'Council';
   $journal->income_id= $permit->id;
 $journal->truck_id= $movement->truck_id;
  $journal->credit =$request->council;
  $journal->currency_code =  'TZS';
  $journal->exchange_rate= '1';
$journal->added_by=auth()->user()->added_by;;
   $journal->notes= "Council of Shipment " .$name ."  to Driver  ". $driver->driver_name ." with Truck ".$truck->truck_name . " - " .$truck->reg_no;
  $journal->save();
}

if($request->consultant > 0){ 
                     $ctpmt['route_id']=$movement->route_id;
                        $ctpmt['added_by']=auth()->user()->added_by;
                        $ctpmt['driver_id']=$movement->driver_id;
                        $ctpmt['truck_id']=$movement->truck_id;
                       $ctpmt['movement_id']=$movement->id;
                         $ctpmt['value']=$request->consultant;
                         $ctpmt['type']='Consultant';
                         $ctpmt['permit_id']=$permit->id;
 $consul= PermitType ::create($ctpmt);

 $crb= AccountCodes::where('account_name','Border Permit')->first();
    $journal = new JournalEntry();
  $journal->account_id = $crb->id;
 $date = explode('-',$permit->date);
  $journal->date =   $permit->date;
  $journal->year = $date[0];
  $journal->month = $date[1];
 $journal->transaction_type = 'permit';
  $journal->name = 'Border Permit';
$journal->reference = 'Consultant';
  $journal->debit = $request->consultant ;
  $journal->income_id= $permit->id;
 $journal->truck_id= $movement->truck_id;
   $journal->currency_code =  'TZS';
  $journal->exchange_rate= '1';
$journal->added_by=auth()->user()->added_by;
 $journal->notes= "Consultant of Shipment " .$name ."  to Driver  ". $driver->driver_name ." with Truck ".$truck->truck_name . " - " .$truck->reg_no;
  $journal->save();


  $codes= AccountCodes::where('account_name','Payables')->first();
  $journal = new JournalEntry();
  $journal->account_id = $codes->id;
   $date = explode('-',$permit->date);
  $journal->date =   $permit->date;
  $journal->year = $date[0];
  $journal->month = $date[1];
   $journal->transaction_type = 'permit';
  $journal->name = 'Border Permit';
   $journal->reference = 'Consultant';
   $journal->income_id= $permit->id;
 $journal->truck_id= $movement->truck_id;
  $journal->credit =$request->consultant;
  $journal->currency_code =  'TZS';
  $journal->exchange_rate= '1';
$journal->added_by=auth()->user()->added_by;;
   $journal->notes= "Consultant of Shipment " .$name ."  to Driver  ". $driver->driver_name ." with Truck ".$truck->truck_name . " - " .$truck->reg_no;
  $journal->save();
}





                        $user_id=auth()->user()->added_by;
                        $quotation = CargoLoading::where('added_by', auth()->user()->added_by)->where('status','3')->get();
                        $costs = Cost_function::all()->where('user_id',$user_id);
                       
                        return redirect(route('order.loading'))->with(['quotation'=> $quotation,'costs'=>$costs,'success'=>'Fuel and Mileage Assigned Successfully']);
                            break;




                    case 'loading':
                        $movement= CargoLoading::find($id);
                            if(!empty($request->receipt)){
                              $data['receipt']=$request->receipt;
                           }
                             $data['status']=4;
                        $result=$movement->update($data);
                         
                    CargoCollection::where('id',$movement->collection_id)->update(['status'=>4]);;   

                        if(!empty($result)){
                            $activity = Activity::create(
                                [ 
                                    'added_by'=>auth()->user()->added_by,
                                    'module_id'=>$movement->pacel_id,
                                    'module'=>'Cargo',
                                    'activity'=>"Confirm Loading",
                                    'notes'=>$request->notes,
                                'loading_id'=>$id,
                                   'date'=>$request->collection_date,
                                ]
                                );                      
               }
        
                        $user_id=auth()->user()->added_by;
                        $quotation = CargoLoading::where('added_by', auth()->user()->added_by)->where('status','4')->get();
                        $costs = Cost_function::all()->where('user_id',$user_id);
                       
                        return redirect(route('order.offloading'))->with(['quotation'=> $quotation,'costs'=>$costs,'success'=>'Loaded Successfully']);
                            break;

                            case 'offloading':
                                $movement=CargoLoading::find($id);
                                  if(!empty($request->receipt)){
                              $data['receipt']=$request->receipt;
                               $data['damaged']=$request->damaged;
                           }
                             $data['status']=5;
                        $result=$movement->update($data);

                                      $truck=Truck::find($movement->truck_id);
                                         $driver=Driver::find($movement->driver_id);
                                           if(!empty($result)){
                                     $item['truck_status']='Available';
                                      $item['location']=$movement->to_region_id;
                                         $truck->update($item);

                                         if(!empty($truck->connect_horse=='1')){
                                           $trailer=Truck::find($truck->connect_trailer);
                                             $trailer->update($item);
                                               }

                                            $driver->update(['available'=>'1']);                             
                                          }
                                 
                                if(!empty($result)){
                                    $activity = Activity::create(
                                        [ 
                                            'added_by'=>auth()->user()->added_by,
                                            'module_id'=>$movement->pacel_id,
                                            'module'=>'Cargo',
                                            'activity'=>"Confirm Offloading",
                                            'notes'=>$request->notes,
                                            'loading_id'=>$id,
                                           'date'=>$request->collection_date,
                                        ]
                                        );                      
                       }

 
    

                
                                $user_id=auth()->user()->added_by;
                                $quotation =  CargoLoading::where('added_by', auth()->user()->added_by)->where('status','5')->get();
                                $costs = Cost_function::all()->where('user_id',$user_id);
                               
                                return redirect(route('order.delivering'))->with(['quotation'=> $quotation,'costs'=>$costs,'success'=>'Offloaded Successfully']);
                                    break;

                                    case 'delivering':
                                        $movement= CargoLoading::find($id);
                                          if(!empty($request->receipt)){
                              $data['receipt']=$request->receipt;
                           }
                             $data['status']=6;
                        $result=$movement->update($data);

                                       

         //CargoCollection::where('id',$movement->collection_id)->update(['status'=>4]);;   
           //Pacel::where('id',$movement->pacel_id)->update(['good_receive'=>1]);;   

  
                                         
                                        if(!empty($result)){
                                            $activity = Activity::create(
                                                [ 
                                                    'added_by'=>auth()->user()->added_by,
                                                    'module_id'=>$movement->pacel_id,
                                                    'module'=>'Cargo',
                                                    'activity'=>"Confirm Delivery",
                                                 'loading_id'=>$id,
                                                    'notes'=>$request->notes,
                                                   'date'=>$request->collection_date,
                                                ]
                                                );                      
                               }
                        
                                        $user_id=auth()->user()->added_by;
                                        $quotation = CargoLoading::where('added_by', auth()->user()->added_by)->where('status','5')->orwhere('status','6')->get();
                                        $costs = Cost_function::all()->where('user_id',$user_id);
                                       
                                        return redirect(route('order.delivering'))->with(['quotation'=> $quotation,'costs'=>$costs,'success'=>'Delivered Successfully']);
                                            break;


                         case 'driver':
              
                                                               
       $route = Route::find($request->route_id); 
  
       $data['route_id']=$request->route_id;
    $data['fuel_rate']=$request->fuel;
        $data['fuel_used']=$request->fuel;
          $data['date']=$request->date;
        $data['due_fuel']=$request->fuel;
        $data['added_by']=auth()->user()->added_by;
        $data['driver_id']=$request->driver_id;
      $data['truck_id']=$request->truck_id;
 $data['status_approve']='0';
        $fuel= Fuel::create($data);


  $items['route_id']=$request->route_id;
   $items['fuel_rate']=$request->mileage;
    $items['date']=$request->date;
        $items['total_mileage']= $request->mileage;
       $items['due_mileage']= $request->mileage;
        $items['added_by']=auth()->user()->added_by;
        $items['driver_id']=$request->driver_id;
      $items['truck_id']=$request->truck_id;
 $items['status_approve']='0';
$items['payment_status']='0';
        $mileage= Mileage ::create($items);

 $driver=Driver::find($request->driver_id);
   $truck=Truck::find($request->truck_id);
     
 $cr= AccountCodes::where('account_name','Mileage')->first();
    $journal = new JournalEntry();
  $journal->account_id = $cr->id;
  $date = explode('-',$mileage->date);
  $journal->date =   $mileage->date;
  $journal->year = $date[0];
  $journal->month = $date[1];
 $journal->transaction_type = 'return_mileage';
  $journal->name = 'Mileage';
  $journal->debit = $mileage->total_mileage ;
  $journal->income_id= $mileage->id;
 $journal->truck_id= $request->truck_id;
   $journal->currency_code =  'TZS';
  $journal->exchange_rate= '1';
$journal->added_by=auth()->user()->added_by;
     $journal->notes= "Return Mileage  to Driver  ". $driver->driver_name ." with Truck  ".$truck->truck_name. " - " .$truck->reg_no;
  $journal->save();


  $codes= AccountCodes::where('account_name','Payables')->first();
  $journal = new JournalEntry();
  $journal->account_id = $codes->id;
 $date = explode('-',$mileage->date);
  $journal->date =   $mileage->date;
  $journal->year = $date[0];
  $journal->month = $date[1];
    $journal->transaction_type = 'return_mileage';
  $journal->name = 'Mileage';
   $journal->income_id= $mileage->id;
   $journal->truck_id= $request->truck_id;
  $journal->credit =$mileage->total_mileage ;
  $journal->currency_code =  'TZS';
  $journal->exchange_rate= '1';
$journal->added_by=auth()->user()->added_by;
     $journal->notes= "Return Mileage  to Driver  ". $driver->driver_name ." with Truck  ".$truck->truck_name. " - " .$truck->reg_no;
  $journal->save();



   $truck->update(['location'=>$route->to_region_id]);             
   
  if(!empty($truck->connect_horse=='1')){
                                           $trailer=Truck::find($truck->connect_trailer);
                                             $trailer->update(['location'=>$route->to_region_id]); 
                                               }              
                       
                        return redirect(route('order.return'))->with(['success'=>'Fuel and Mileage Assigned Successfully']);
                            break;


             default:
             return abort(404);
             
            }




    }

public function save_wb(Request $request)
    {


$item_id=$request->checked_item_id;

///dd($item_id);
  if(!empty($item_id)){
  $item_count=count($item_id);
   if($item_count > 1){
    for($i = 1, $j=0; $i < count($item_id); $i++){

     $client_one=CargoCollection::where('added_by', auth()->user()->added_by)->where('item_id',$item_id[$i])->first(); 
      $client=CargoCollection::where('added_by', auth()->user()->added_by)->where('item_id',$item_id[$j])->first(); 
       $exchange_one=Pacel::find($client_one->pacel_id);
       $exchange=Pacel::find($client->pacel_id);


   //$result = array_diff( $client_one->owner_id,$client->owner_id);


   if($client_one->owner_id !=$client->owner_id ){
return redirect()->back()->with(['error'=>'You have Chosen different Client']);
    }
   if($exchange_one->currency_code !=$exchange->currency_code ){
return redirect()->back()->with(['error'=>'You have Chosen invoice with different Currency']);
    }



}
}



  if(!empty($item_id)){
    for($i = 0; $i < 1; $i++){
   if(!empty($item_id[$i])){

   $collection=CargoCollection::where('added_by', auth()->user()->added_by)->where('item_id',$item_id[$i])->first(); 
   $good=Pacel::find($collection->pacel_id);

  $invoice= array(
   'pacel_number' => '12AB' ,
   'date' => date('Y-m-d') ,
     'owner_id' => $collection->owner_id ,
     'discount' => '0'  ,
     'status' => '0'  ,
     'currency_code' =>  $good->currency_code,
     'exchange_rate' =>  $good->exchange_rate,
     'added_by'=>auth()->user()->added_by,
           );

$pacel=PacelInvoice::create($invoice);  ;
   $pacel_number = "PCL-INV-".$pacel->id;

}
}
}


 $total = 0;
        $cost['tax'] = 0;
  if(!empty($item_id)){
    for($i = 0; $i < count($item_id); $i++){
   if(!empty($item_id[$i])){
          $acc = PacelItem::find($item_id[$i]); 
         $collect=CargoCollection::where('added_by', auth()->user()->added_by)->where('item_id',$item_id[$i])->first(); 

          $total += $acc->total_cost;
            $cost['tax'] +=$acc->total_tax;
                
                  $items = array(
                     'item_name' => $acc->item_name,
                    'quantity' =>    $acc->quantity,
                    'tax_rate' =>   $acc->tax_rate,
                     'unit' =>  $acc->unit,
                     'charge_type' =>   $acc->charge_type,
                    'distance' =>  $acc->distance,
                     'price' =>   $acc->price,
                    'total_cost' =>   $acc->total_cost,
                    'total_tax' =>   $acc->total_tax,
                     'items_id' =>  $item_id[$i],
                     'end' =>  $collect->end,
                      'truck_id'=>$collect->truck_id,
                       'driver_id'=>$collect->driver_id,
                       'order_no' => $i,
                       'added_by'=>auth()->user()->added_by,
                    'pacel_id' =>$pacel->id);

                  $list=PacelInvoiceItem::create($items);  ;

                   CargoCollection::where('added_by', auth()->user()->added_by)->where('item_id',$item_id[$i])->update(['status' => '5']);

          $client=Client::find($collect->owner_id);

$cr= AccountCodes::where('account_name','Sales')->first();
          $journal = new JournalEntry();
        $journal->account_id = $cr->id;
        $date = explode('-',$pacel->date);
        $journal->date =   $pacel->date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'cargo';
        $journal->name = 'Cargo Invoice';
        $journal->credit = $acc->total_cost *  $pacel->exchange_rate;
        $journal->income_id= $pacel->id;
       $journal->reference= $list->id;
         $journal->truck_id= $collect->truck_id;
         $journal->currency_code =  $pacel->currency_code;
        $journal->exchange_rate= $pacel->exchange_rate;
 $journal->added_by=auth()->user()->added_by;
           $journal->notes= "Invoice with reference no " .$pacel_number. "  by Client ".  $client->name ;
        $journal->save();

if($acc->total_tax > 0){
       $tax= AccountCodes::where('account_name','VAT OUT')->first();
          $journal = new JournalEntry();
        $journal->account_id = $tax->id;
        $date = explode('-',$pacel->date);
        $journal->date =   $pacel->date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
        $journal->transaction_type = 'cargo';
        $journal->name = 'Cargo Invoice';
        $journal->credit = $acc->total_tax *  $pacel->exchange_rate;
       $journal->income_id= $pacel->id;
      $journal->reference= $list->id;
         $journal->truck_id= $collect->truck_id;
         $journal->currency_code =  $pacel->currency_code;
        $journal->exchange_rate= $pacel->exchange_rate;
         $journal->added_by=auth()->user()->added_by;
           $journal->notes= "Invoice Tax with reference no " .$pacel_number. "  by Client ".  $client->name ;
        $journal->save();
}

        $codes= AccountCodes::where('account_group','Receivables')->first();
        $journal = new JournalEntry();
        $journal->account_id = $codes->id;
         $date = explode('-',$pacel->date);
        $journal->date =  $pacel->date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
          $journal->transaction_type = 'cargo';
       $journal->name = 'Cargo Invoice';
       $journal->debit =($acc->total_cost +$acc->total_tax ) *  $pacel->exchange_rate;
           $journal->income_id= $pacel->id;
          $journal->reference= $list->id;
         $journal->truck_id= $collect->truck_id;
         $journal->currency_code =  $pacel->currency_code;
        $journal->exchange_rate= $pacel->exchange_rate;
       $journal->notes= "Debit Receivables for Invoice with reference no " .$pacel_number. "  by Client ".  $client->name ;      
         $journal->added_by=auth()->user()->added_by;
        $journal->save();

                  }
                  }

                $random = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(4/strlen($x)) )),1,4);
                $cost['pacel_number'] = "PCL-INV-".$pacel->id;
                $cost['confirmation_number'] = "PCL-INV-".$random.$pacel->id;
                $cost['due_amount'] =  $cost['tax'] +  $total;
                $cost['amount'] =  $cost['tax'] +  $total;
                PacelInvoice::where('id',$pacel->id)->update($cost);
                }


                return redirect(route('pacel.invoice'))->with(['success'=>'Created Successfully']);
}


else{
  return redirect(route('order.wb'))->with(['error'=>'You have not chosen an entry']);
}


}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

  public function findPrice(Request $request)
    {

              $date = today()->addDays(10)->format('Y-m-d');

               $data=TruckInsurance::leftJoin('stickers', 'stickers.truck_id','truck_insurances.truck_id')
               ->where('truck_insurances.truck_id',$request->id)
               ->where('truck_insurances.expire_date', '<=', $date) 
                 ->orwhere('stickers.truck_id',$request->id)
               ->orwhere('stickers.expire_date', '<=', $date)      
            ->select('stickers.*','truck_insurances.*')
        ->get();
               $id= $request->id;
              if(!empty($data[0])){
                 return response()->json($data);;
                 }                 

    }





public function report(Request $request)
    {
 //
         $region = Region::all();

if ($request->ajax()) {
            $data =CargoLoading::query();
            $start_date = (!empty($_GET["start_date"])) ? ($_GET["start_date"]) : ('');
            $end_date = (!empty($_GET["end_date"])) ? ($_GET["end_date"]) : ('');
            $status = (!empty($_GET["status"])) ? ($_GET["status"]) : ('');
            $from = (!empty($_GET["from"])) ? ($_GET["from"]) : ('');
            $to = (!empty($_GET["to"])) ? ($_GET["to"]) : ('');


     //filter selected columns
            if($start_date && $end_date){
             $start_date = date('Y-m-d', strtotime($start_date));
             $end_date = date('Y-m-d', strtotime($end_date));
             $data->whereRaw("date(cargo_loading.collection_date) >= '" . $start_date . "' AND date(cargo_loading.collection_date) <= '" . $end_date . "'");
            }
            if($from && $from!="all")
            $data->whereRaw("cargo_loading.from_region_id = '" . $from . "'");
            if($to && $to!="all")
            $data->whereRaw("cargo_loading.to_region_id= '" . $to . "'");
            if($status && $status!="all")
            $data->whereRaw("cargo_loading.status = '" . $status . "'");

          $data->where('added_by',auth()->user()->added_by);

            $data2 = $data->select('*')->where('added_by',auth()->user()->added_by);


            return Datatables::of($data2)
                    ->addIndexColumn()
                    ->editColumn('date', function ($row) {
                        $newDate = date("d/m/Y", strtotime($row->collection_date));
                        return $newDate;
                   })
                   ->editColumn('pacel_number', function ($row) {
                    return $row->pacel_number  ;
               })
                  
               ->editColumn('receiver', function ($row) {
                $user = Client::find($row->owner_id);
                   return $user->name;
           })
                  
                    ->editColumn('from_to', function ($row) {
                       $from = Region::find($row->from_region_id);
                        $end= Region::find($row->to_region_id);
                        return 'From '.$from->name. ' to ' .$end->name;
                   })

                  
                    ->editColumn('truck', function ($row) {
                        $truck = Truck::find($row->truck_id);
                       return $truck->reg_no;

                    })

                      ->editColumn('driver', function ($row) {
                        $driver= Driver::find($row->driver_id);
                       return $driver->driver_name;

                    })
                     ->editColumn('weight', function ($row) {
                         return $row->quantity;
                    })

                    ->editColumn('status', function ($row) {
                        if($row->status == 3)
                         return '<div class="badge badge-dark badge-shadow">Collected</div>';
                        elseif($row->status == 4)
                        return '<div class="badge badge-info badge-shadow">On Transit</div>';
                        elseif($row->status == 5)
                        return '<div class="badge badge-primary badge-shadow">Off Loaded</div>';
                        elseif($row->status == 6)
                        return '<div class="badge badge-success  badge-shadow">Delivered</div>';
                        
                    })
                    ->rawColumns(['status','date','pacel_number','from_to'])
                   
                    
                    ->make(true);
        }

       return view('order_movement.report',compact('region'));

    }

 public function findReport (Request $request)
    {

         $data['report'] = CargoLoading::where('added_by', auth()->user()->added_by)->query();

          if(!empty($request->from)){
              $data['report'] = $data['report']->where('from_region_id',$request->from);
}
 if(!empty($request->to)){
              $data['report'] =$data['report']->where('to_region_id',$request->to);
}
 if(!empty($request->status)){
              $data['report'] = $data['report']->where('status',$request->status);
}
 if(!empty($request->start_date) && !empty($request->end_date)){
              $data['report'] =$data['report']->whereBetween('collection_date',  [$request->start_date, $request->end_date]);
}

$data['report']=$data['report']->get();
            
               $data['region'] = Region::all();

               // return response()->json($report);;
                   return response()->json(['html' => view('order_movement.addreport', $data)->render()]);           

    }



}
