<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\FieldStaff;
use App\Models\GoodMovement;
use App\Models\Manufacturing\Movement;
use App\Models\Manufacturing\GoodMovementItems;

use App\Models\Inventory;
use  App\Models\POS\Items;
use App\Models\Location;
use App\Models\Manufacturing\MainMovement;
use Illuminate\Http\Request;
use PDF;

class GoodMovementController extends Controller
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
        $inventory = Items::all();
        $staff = FieldStaff::all();
        $location = Location::all();

        $name = Items::all();
        $products = Items::all()->where('type', 2);

        $movement = MainMovement::all();
        return view('inventory.good_movement', compact('movement', 'inventory', 'staff', 'location', 'name'));
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
        if (($request->source_location == $request->destination_location)) {
            return redirect(route('good_movement.index'))->with(['error' => 'You have chosen the same location']);
        } else {

            $data['added_by'] = auth()->user()->added_by;
            $data['staff'] = $request->staff;
            $data['date'] = $request->date;
            $data['source_location'] = $request->source_location;
            $data['destination_location'] = $request->destination_location;
            $data['status'] = 0;

           $main_movement =  MainMovement::create($data);
           $data2['reference_no'] = 'MOV-'.$data['source_location'].'-'.$data['destination_location'].'-'.$main_movement->id;
           MainMovement::where('id',$main_movement->id)->update($data2);
           
            $nameArr =$request->item_name;
            $qtyArr = $request->quantity;
            $unitArr = $request->unit;

            
         
            if(!empty($nameArr)){
                for($i = 0; $i < count($nameArr); $i++){
                    if(!empty($nameArr[$i])){
                        $item_id = $nameArr[$i];
                        $quantity = $qtyArr[$i];
                        $result = $this->movement_model->check_quantity($data['source_location'], $item_id, $quantity);
                        if($result === false){
                            return redirect()->back()->with(['error'=>'no enough quantity to be transfered']);
                        }
                    }
                }

                for($i = 0; $i < count($nameArr); $i++){
                    if(!empty($nameArr[$i])){
                        $item_id = $nameArr[$i];
                        $quantity = $qtyArr[$i];
                        $movement_data = $request->all();
                        $movement_data['added_by'] = auth()->user()->added_by;
                        $movement_data['main_movement_id'] = $main_movement->id;
                        $movement_data['item_id'] = $item_id;
                        $movement_data['source_location'] = $request->source_location;
                        $movement_data['destination_location'] = $request->destination_location;
                        $movement_data['quantity'] = $quantity;
                        $movement_data['staff'] = $request->staff;
                        $movement_data['date'] = $request->date;

                        $movement = GoodMovement::create($movement_data);
                      //  $this->movement_model->create_item_movement($movement_data['source_location'],$movement_data['destination_location'],$item_id,$quantity,$movement->id);

                        
                 
                           
        
        
                    }
                }
                // $cost['reference_no']= "BOF_NO-".$purchase->id;
                
                // BillOfMaterial::where('id',$purchase->id)->update($cost);
            }    

            return redirect(route('good_movement.index'))->with(['success' => 'Good Movement Created Successfully']);


        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
       $data['purchases'] =  MainMovement::find($id);
        $data['items'] = GoodMovement::all()->where('main_movement_id', $id);

        return view('inventory.good_movement_details',$data);
    }

    public function movement_pdfview(Request $request)
    {
        //
        $id = $request->id;
       
        $data['purchases'] =  MainMovement::find($id);
        $data['mov_items'] = GoodMovement::all()->where('main_movement_id', $id);
   
         // view()->share(['purchases' => $data['purchases'], 'items' => $data['items']]);

        if ($request->has('download')) {
            $pdf = PDF::loadView('inventory.good_movement_dateail_pdf',$data)->setPaper('a4', 'potrait');
            return $pdf->download('Movenet REF NO # ' .  $data['purchases']->reference_no . ".pdf");
        }
       // return view('inv_pdfview');
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
      
    
      

        $name = Items::all();
        $products = Items::all()->where('type', 2);




        $inventory = Items::all();
        $staff = FieldStaff::all();
        $location = Location::all();
        $data = MainMovement::find($id);
        $items = GoodMovement::all()->where('main_movement_id', $id);
        return view('inventory.good_movement', compact('data', 'items','inventory', 'staff', 'location', 'id','name','products'));
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
        if (($request->source_location == $request->destination_location)) {
            return redirect(route('good_movement.index'))->with(['error' => 'You have chosen the same location']);
        } else {

            $data['added_by'] = auth()->user()->added_by;
            $data['staff'] = $request->staff;
            $data['date'] = $request->date;
            $data['source_location'] = $request->source_location;
            $data['destination_location'] = $request->destination_location;
            $data['status'] = 0;

           $main_movement =  MainMovement::find($id);
           $main_movement->update($data);
           $data2['reference_no'] = 'MOV-'.$data['source_location'].'-'.$data['destination_location'].'-'.$main_movement->id;
           MainMovement::where('id',$main_movement->id)->update($data2);
           
            $nameArr =$request->item_name;
            $qtyArr = $request->quantity;
            $unitArr = $request->unit;

            
         
            if(!empty($nameArr)){
                for($i = 0; $i < count($nameArr); $i++){
                    if(!empty($nameArr[$i])){
                        $item_id = $nameArr[$i];
                        $quantity = $qtyArr[$i];
                        $result = $this->movement_model->check_quantity($data['source_location'], $item_id, $quantity);
                        if($result === false){
                            return redirect()->back()->with(['error'=>'no enough quantity to be transfered']);
                        }
                    }
                }

                for($i = 0; $i < count($nameArr); $i++){
                    if(!empty($nameArr[$i])){
                        $item_id = $nameArr[$i];
                        $quantity = $qtyArr[$i];
                       // $movement_data = $request->all();
                        $movement_data['added_by'] = auth()->user()->added_by;
                        $movement_data['main_movement_id'] = $main_movement->id;
                        $movement_data['item_id'] = $item_id;
                        $movement_data['source_location'] = $request->source_location;
                        $movement_data['destination_location'] = $request->destination_location;
                        $movement_data['quantity'] = $quantity;
                        $movement_data['staff'] = $request->staff;
                        $movement_data['date'] = $request->date;
                        
                        $exist = GoodMovement::where('main_movement_id',$id)->where('item_id',$item_id)->count();
                        if($exist > 0){
                            $movement = GoodMovement::where('main_movement_id',$id)->where('item_id',$item_id)->update($movement_data);
                        }else{
                            $movement = GoodMovement::create($movement_data);
                        }
                        

                        
                 
                           
        
        
                    }
                }
                // $cost['reference_no']= "BOF_NO-".$purchase->id;
                
                // BillOfMaterial::where('id',$purchase->id)->update($cost);
            }    

            return redirect(route('good_movement.index'))->with(['success' => 'Good Movement Update Successfully']);


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
        $movement =  GoodMovement::find($id);
        $movement->delete();

        return redirect(route('good_movement.index'))->with(['success' => 'Good Movement  Deleted Successfully']);
    }

    public function approve($id)
    {
        //


        //get gud issue
        $data =  MainMovement::find($id);
        $good_movement = GoodMovement::all()->where('main_movement_id',$id);

        foreach($good_movement as $row){

            $result = $this->movement_model->check_quantity($row->source_location, $row->item_id, $row->quantity);
            if($result === false){
                return redirect(route('good_movement.index'))->with(['success' => 'not confirmed no enough items']);
            }


        }

        foreach($good_movement as $row){

            $result = $this->movement_model->create_item_movement($row->source_location,$row->destination_location,$row->item_id,$row->quantity,$row->id);

        }

            $list['status'] = '1';
            $data->update($list);

            return redirect(route('good_movement.index'))->with(['success' => 'Good Movement Approved Successfully']);
      
    }
}
