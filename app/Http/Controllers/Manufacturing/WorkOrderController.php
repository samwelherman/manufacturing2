<?php

namespace App\Http\Controllers\Manufacturing;

use App\Http\Controllers\Controller;
use App\Models\Manufacturing\WorkOrder;
use App\Models\Manufacturing\WorkOrderItems;
// use App\Models\Manufacturing\Inventory;
use App\Models\Manufacturing\Issue;
// use App\Models\Manufacturing\Location;
use App\Models\Screp;

use  App\Models\POS\Items;
use App\Models\Location;
use Carbon\Carbon;
use App\Models\AccountCodes;
use App\Models\Transaction;
use App\Models\Accounts;
use App\Models\JournalEntry;
use App\Models\GoodMovement;

use App\Models\Manufacturing\BillOfMaterial;
use App\Models\Manufacturing\BillOfMaterialInventory;
use App\Models\Manufacturing\Movement;
use App\Models\Manufacturing\Store_Items;

use App\Models\User;
use App\Models\POS\Client;


use Illuminate\Http\Request;

class WorkOrderController extends Controller
{
    protected $movement_model;

    public function __construct($movement_model = null)
    {
        $this->movement_model = new Movement();

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['work_orders'] = WorkOrder::orderBy('id','DESC')->where('added_by', auth()->user()->added_by)->get();

        $data['name'] = BillOfMaterial::all();

        $data['locationWs'] = Location::all()->where('type', 1)->where('added_by', auth()->user()->added_by);

        $data['locationFs'] = Location::all()->where('type', 2)->where('added_by', auth()->user()->added_by);

        $data['locations'] = Location::all()->where('type', 3)->where('added_by', auth()->user()->added_by);


        $data['items'] = Items::all()->where('type', 2);
        $data['client'] = Client::where('user_id', auth()->user()->added_by)->get();
        $data['users'] = User::all()->where('added_by', auth()->user()->added_by);

        return view('manufacturing.work_order', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $work_order = WorkOrder::all();

        $location = Location::all()->where('type', 4);
        $item = Items::all()->where('type', 2);

        $users = User::all();

        return view('manufacturing.work_order_details', compact('work_order', 'item', 'location', 'users', 'billofmaterials'));
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

        $today = Carbon::now()->format('Y-m-d');

        // $data=$request->post();
        $count = WorkOrder::where('added_by', auth()->user()->added_by)->count();
        $pro = $count + 1;
        $data['reference_no'] = "WOD_NO" . $pro;


       // $data['unit'] = $request->unit;
        $data['type'] = $request->type;
        //$data['quantity'] = $request->quantity;
        //$data['due_quantity'] = $request->quantity;
        //$data['balance'] = $request->quantity;
       // $data['product'] = $request->product;


        $bill   = BillOfMaterial::find($request->product);

        //$data['product_name'] = $bill->product;

        $data['work_center'] = $request->work_center;

        $data['shift'] = $request->shift;

        $data['finished_store'] = $request->finished_store;

        $data['location_id'] = $request->location_id;

        $data['description'] = $request->description;

        $data['expected_date'] = $request->expected_date;



        $data['added_by'] = auth()->user()->added_by;
        $data['responsible_id'] = $request->user_id;
        $data['created_by'] = auth()->user()->id;
        $data['created_date'] = $today;
        $work_order = WorkOrder::create($data);

        $nameArr =$request->item_name;
        $qtyArr = $request->quantity;
        $unitArr = $request->unit;

        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){

                    $bill_of_material = BillOfMaterial::find($nameArr[$i]);
                    
                   
                    
                    $items = array(
                        'bill_of_material_id'=>$bill_of_material->id,
                        'work_order_id'=>$work_order->id,
                        
                        'quantity' =>   $qtyArr[$i],
                        'unit' => $unitArr[$i],
                        'product' => $bill_of_material->product,
                        'added_by' => auth()->user()->added_by,
                         
                        );

                        WorkOrderItems::create($items);
                       
                     
    
    
                }
            }
            
        }   




        return redirect(route('work_order.index'))->with(['success' => 'Work Order Created Successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $location = Location::all()->where('type', 4);
        $work_centre = Location::all()->where('type', 1);
        switch ($request->type) {
            case 'show':

                return view('manufacturing.issue', compact('id', 'location', 'work_centre'));
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
        $data['data'] =  WorkOrder::find($id);
        $data['id'] = $id;
        $data['billofmaterials'] = BillOfMaterial::all()->where('added_by', auth()->user()->added_by);
        $data['locationWs'] = Location::all()->where('type', 1)->where('added_by', auth()->user()->added_by);
        $data['locationFs'] = Location::all()->where('type', 2)->where('added_by', auth()->user()->added_by);
        $data['locations'] = Location::all()->where('type', 3)->where('added_by', auth()->user()->added_by);
        $data['items'] = Items::all()->where('type', 2);
        $data['client'] = Client::where('user_id', auth()->user()->added_by)->get();
        $data['users'] = User::all()->where('added_by', auth()->user()->added_by);


        return view('manufacturing.work_order', $data);
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
        $work_order =  WorkOrder::find($id);
        // $data=$request->post();

        $data['unit'] = $request->unit;

        $data['type'] = $request->type;

        $data['quantity'] = $request->quantity;
        $data['due_quantity'] = $request->quantity;

        $data['balance'] = $request->quantity;


        $data['product'] = $request->product;


        $bill   = BillOfMaterial::find($request->product);


        $data['product_name'] = $bill->product;

        //dd($data['product_name']);     

        $data['work_center'] = $request->work_center;

        $data['finished_store'] = $request->finished_store;

        $data['location_id'] = $request->location_id;

        $data['description'] = $request->description;

        $data['expected_date'] = $request->expected_date;



        $data['added_by'] = auth()->user()->added_by;
        $data['responsible_id'] = $request->user_id;
        $data['created_by'] = auth()->user()->id;

        $work_order->update($data);

        return redirect(route('work_order.index'))->with(['success' => 'Work Order Updated Successfully']);
    }


    public function findbillProduct(Request $request)
    {

        $district = SchoolLevel::where('level', $request->id)->get();
        return response()->json($district);
    }

    public function approve($id)
    {
        //
        $purchase = WorkOrder::find($id);
        $data['status'] = 1;
        $purchase->update($data);
        return redirect(route('work_order.index'))->with(['success' => 'Approved Successfully']);
    }


    // $temp_sum = array_sum($temp);


    // $dt2 = Location::find($purchase->location_id);

    // if($dt2->quantity >= $temp_sum){

    //         $dataR['status'] = 2;

    //         $purchase->update($dataR);

    //         $diff=$dt2->quantity - $temp_sum;

    //         //update quantity on inventory store after release 
    //         $lctr = Location::where('id',$purchase->location_id)->update(['quantity' => $diff]);

    //         $dt3 = Location::find($purchase->work_center);

    //         $data22 =$dt3->quantity + $temp_sum;

    //         //update quantity on work center store after release
    //         Location::where('id',$purchase->work_center)->update(['quantity' => $data22]);


    //      return redirect(route('work_order.index'))->with(['success'=>'Released Successfully']);

    // }

    // else{
    //     return redirect(route('work_order.index'))->with(['error'=>'Inventory Store Quanttity is low']);
    // }

    public function release($id)
    {
        //
        $purchase = WorkOrder::find($id);
        if (!empty($purchase)) {

        $work_order_items = WorkOrderItems::all()->where('work_order_id',$purchase->id);

        foreach($work_order_items as $items){
            $inv_items   = BillOfMaterialInventory::where('bill_of_material_id', $items->bill_of_material_id)->get();

            $total_qty = 0;
            if ($inv_items->isNotEmpty()) {

                foreach ($inv_items as $row) {

                    $data['id'] = $row->items_id;

                    $data['quantity_wk'] = $row->quantity * $items->quantity;
                    $total_qty += $row->quantity * $items->quantity;


                    $dt2 = Items::find($row->items_id);

                    $store_balance = Store_Items::where('location_id',$purchase->location_id)->where('items_id',$row->items_id)->get()->first();
                    if(empty($store_balance)){
                        return redirect(route('work_order.index'))->with(['error' => 'There is one raw material not registerd in the store'.$row->items_id.'and'.$purchase->location_id]);

                    }
                    if ($store_balance->quantity >= $data['quantity_wk']) {

                        $temp[] = $data;
                    } else {
                        return redirect(route('work_order.index'))->with(['error' => 'Inventory Store Quanttity is low']);
                    }
                }

                foreach ($inv_items as $row) {

                    $data['id'] = $row->items_id;

                    $data['quantity_wk'] = $row->quantity * $items->quantity;
                    $total_qty += $row->quantity * $items->quantity;


                    $dt2 = Items::find($row->items_id);

                    $store_balance = Store_Items::where('location_id',$purchase->location_id)->where('items_id',$row->items_id)->get()->first();
                    if(empty($store_balance)){
                        return redirect(route('work_order.index'))->with(['error' => 'There is one raw material not registerd in the store'.$row->items_id.'and'.$purchase->location_id]);

                    }
                    if ($store_balance->quantity >= $data['quantity_wk']) {
                        $temp_quantity = $total_qty;
                $pur_items['release_quantity'] = $temp_quantity;
                $pur_items['due_quantity'] = $temp_quantity;
              //  $work_order_items->update($pur_items);

                WorkOrderItems::find($items->id)->update($pur_items);

                $movement_items = [
                    'item_id'=>$row->items_id,
                    'staff'=>auth()->user()->id,
                    'added_by'=>auth()->user()->id,
                    'source_location'=>$purchase->location_id,
                    'destination_location'=>$purchase->work_center,
                    'quantity'=> $data['quantity_wk'],
 
                 ];
                 $movement = GoodMovement::create($movement_items);
                 $this->movement_model->create_item_movement($purchase->location_id,$purchase->work_center,$row->items_id,$data['quantity_wk'],$movement->id);


                    } else {
                        return redirect(route('work_order.index'))->with(['error' => 'Inventory Store Quanttity is low']);
                    }
                }

                //dd($total_qty);

                $temp_quantity = $total_qty;
                $pur_items['release_quantity'] = $temp_quantity;
                $pur_items['due_quantity'] = $temp_quantity;
              //  $work_order_items->update($pur_items);

              //  WorkOrderItems::find($items->id)->update($pur_items);


                // $movement_items = [
                //     'item_id'=>$row->items_id,
                //     'staff'=>auth()->user()->id,
                //     'added_by'=>auth()->user()->id,
                //     'source_location'=>$purchase->location_id,
                //     'destination_location'=>$purchase->work_center,
                //     'quantity'=> $data['quantity_wk'],
 
                //  ];
                //  $movement = GoodMovement::create($movement_items);
                //  $this->movement_model->create_item_movement($purchase->location_id,$purchase->work_center,$row->items_id,$data['quantity_wk'],$movement->id);

                 $purchase->update(['status'=>2]);

                return redirect(route('work_order.index'))->with(['success' => 'Released Successfully']);
            } else {
                return redirect(route('work_order.index'))->with(['error' => 'Bill Of Material Inventory Not Found']);
            }
            
        }

          


        } else {
            return redirect(route('work_order.index'))->with(['error' => 'Purchase ID Not Found']);
        }
    }

    public function produce(Request $request, $id)
    {
        //withdraw_quantity
        //items
        
        $purchase = WorkOrder::find($id);


        //saving remained material as screps
        if($request->screp){
            
        $data['quantity'] = $request->screp;
        $data['resposible_person'] = $request->user_id;
        $data['added_by'] = auth()->user()->id;
        $data['balance'] = 0;
        $data['shift'] = $purchase->shift;
        $data['work_order_id'] = $id;
        $data['wasted'] = 0;
        Screp::create($data);
        }



     

        if (!empty($purchase)) {

            $temp_sumArr = $request->withdraw_quantity;
            $itemArr = $request->items;
            
            if(!empty($itemArr)){

                for($i = 0; $i < count($itemArr); $i++){
                    $temp_sum = $temp_sumArr[$i];
                    $work_order_items = WorkOrderItems::find($itemArr[$i]);

                    $bill_of_material = BillOfMaterialInventory::all()->where('bill_of_material_id',$work_order_items->bill_of_material_id);
                    
                    foreach($bill_of_material as $row){
                        $raw_material = $row->quantity*$temp_sum;
                        $store_balance = Store_Items::where('location_id',$purchase->work_center)->where('items_id',$row->items_id)->get()->first();
                         
                        if(empty($store_balance)){
                            return redirect(route('work_order.index'))->with(['error' => 'Item  or Location  Not Found']);
                        }
                        if($store_balance->quantity < $raw_material ){
                           return redirect(route('work_order.index'))->with(['error' => 'Items not available1']);

                        }
                    }
                
                    //find raw material and deduct them from production store to dispose store
                    foreach($bill_of_material as $row){
                        $raw_material = $row->quantity*$temp_sum;                      

                        $movement_items = [
                            'item_id'=>$row->items_id,
                            'staff'=>auth()->user()->id,
                            'added_by'=>auth()->user()->id,
                            'source_location'=>$purchase->location_id,
                            'destination_location'=>4,
                            'quantity'=> $raw_material,
         
                         ];
                         $movement = GoodMovement::create($movement_items);
                       
                         $this->movement_model->create_item_movement($purchase->work_center,4,$row->items_id,$raw_material,$movement->id);
                    
                    }
              
                $this->movement_model->create_item_movement1('',$purchase->finished_store,$work_order_items->product,$temp_sum,'');

                $dataP['balance'] =  $temp_sum;
                $work_order_items->update($dataP);

             

               
                }
                $purchase->update(['status' => 2]);


            }



            $dt2 = Location::find($purchase->work_center);



                //$dataP['status'] = 3;



                $dataP['balance'] = $purchase->balance - $temp_sum;

                if ($dataP['balance'] != 0) {
                    $dataP['status'] = 2;
                } else {
                    $dataP['status'] = 3;
                }
                $prd = $purchase->update($dataP);

              

               


             

            


        


                return redirect(route('work_order.index'))->with(['success' => 'Produced Successfully']);





            // }

        } else {
            return redirect(route('work_order.index'))->with(['error' => 'Purchase ID Not Found']);
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
        $work_order =  WorkOrder::find($id);
        $work_order->delete();

        return redirect(route('work_order.index'))->with(['success' => 'Work Order Deleted Successfully']);
    }

    public function finish(Request $request, $id)
    {

        $work_order =  WorkOrder::find($id);

        $data2['status'] = 3;
        $work_order->update($data2);


        if ($work_order->due_quantity > 0) {

            $inv = Items::find($work_order->product_name);

            $d = date('Y-m-d');

            $codes = AccountCodes::where('account_name', 'Inventory')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
            $journal->account_id = $codes->id;
            $date = explode('-', $d);
            $journal->date =   $d;
            $journal->year = $date[0];
            $journal->month = $date[1];
            $journal->transaction_type = 'manufacturing';
            $journal->name = 'Manufacturing Defective Product';
            $journal->income_id = $id;
            $journal->credit = $inv->cost_price * $work_order->due_quantity;
            $journal->added_by = auth()->user()->added_by;
            $journal->notes = "Manufacturing Defective Product -  " . $inv->name;
            $journal->save();

            $cr = AccountCodes::where('account_name', 'Defective Item')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
            $journal->account_id = $cr->id;
            $date = explode('-', $d);
            $journal->date =   $d;
            $journal->year = $date[0];
            $journal->month = $date[1];
            $journal->transaction_type = 'manufacturing';
            $journal->name = 'Manufacturing Defective Product';
            $journal->income_id = $id;
            $journal->debit = $inv->cost_price * $work_order->due_quantity;
            $journal->added_by = auth()->user()->added_by;
            $journal->notes = "Manufacturing Defective Product -  " . $inv->name;
            $journal->save();
        }



        return redirect(route('work_order.index'))->with(['success' => 'Production Ended Successfully']);
    }


    public function discountModal(Request $request)
    {
        $id = $request->id;
        $type = $request->type;
        if ($type == 'produce') {
            $work_order_items = WorkOrderItems::all()->where('work_order_id',$id);
            $user = User::all();
            return view('manufacturing.produce', compact('id','work_order_items','user'));
        } 
        else  if ($type == 'screp') {
            $screp = Screp::find($id);
          
            return view('manufacturing.update_screp', compact('id','screp'));
        }
        
        else if ($type == 'overhead') {
            $bank_accounts = AccountCodes::where('added_by', auth()->user()->added_by)->where('account_group', 'Cash and Cash Equivalent')->orwhere('account_name', 'Payables')->where('added_by', auth()->user()->added_by)->get();
            $chart_of_accounts = AccountCodes::where('account_group', '!=', 'Cash and Cash Equivalent')->where('added_by', auth()->user()->added_by)->get();
            return view('manufacturing.overhead', compact('id', 'bank_accounts', 'chart_of_accounts'));
        }
    }

    public function issue(Request $request, $id)
    {

        $data = $request->all();
        $data['added_by'] = auth()->user()->id;
        Issue::create($data);

        $work_order =  WorkOrder::find($id);

        $data2['status'] = 1;
        $work_order->update($data2);

        return redirect(route('work_order.index'))->with(['success' => 'Work Issued Successfully']);
    }


    public function produce2(Request $request, $id)
    {
        //
        $purchase = WorkOrder::find($id);

        if (!empty($purchase)) {

            $temp_sum = $request->withdraw_quantity;


            $dt2 = Location::find($purchase->work_center);

            if ($dt2->quantity >= $temp_sum) {

                $dataP['status'] = 3;

                $prd = $purchase->update($dataP);

                $diff = $dt2->quantity - $temp_sum;

                //update quantity on work center store after release 
                $lctr = Location::where('id', $purchase->work_center)->update(['quantity' => $diff]);

                $dt3 = Location::find($purchase->finished_store);

                $data22 = $dt3->quantity + $temp_sum;

                //update quantity on finished  store after release
                Location::where('id', $purchase->finished_store)->update(['quantity' => $data22]);


                return redirect(route('work_order.index'))->with(['success' => 'Produced Successfully']);
            } else {
                return redirect(route('work_order.index'))->with(['error' => 'Work Center Store Quanttity is low']);
            }




            // }

        } else {
            return redirect(route('work_order.index'))->with(['error' => 'Purchase ID Not Found']);
        }
    }
}
