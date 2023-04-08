<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\FieldStaff;
use App\Models\GoodMovement;
use App\Models\Inventory;
use App\Models\Location;
use App\Models\Manufacturing\Movement;
use App\Models\Manufacturing\Store_Items;
use App\Models\POS\Items;
use Illuminate\Http\Request;

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
        $inventory= Items::all();
        $staff=FieldStaff::all();
        $location=Location::all();
        $movement= GoodMovement::all();
       return view('inventory.good_movement',compact('movement','inventory','staff','location'));
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
        $data = $request->all();
        $data['added_by']=auth()->user()->id;

        $store_balance = Store_Items::where('location_id',$request->source_location)->where('items_id',$request->item_id)->get()->first();

        if ($store_balance->quantity >= $request->quantity) {

        $movement= GoodMovement::create($data);

        $this->movement_model->create_item_movement($request->source_location,$request->destination_location,$request->item_id,$request->quantity,$movement->id);
      
        return redirect(route('good_movement.index'))->with(['success'=>'Good Movement Created Successfully']);
        }

        else{
            return redirect(route('good_movement.index'))->with(['error'=>'You have exceeded the Quantity']);
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
        $inventory= Inventory::all();
        $staff=FieldStaff::all();
        $location=Location::all();
        $data= GoodMovement::find($id);
       return view('inventory.good_movement',compact('data','inventory','staff','location','id'));
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
        $movement=GoodMovement::find($id);

        $data = $request->all();
        $data['added_by']=auth()->user()->id;

        $inv=Inventory::where('id',$request->item_id)->first();

        if(($request->quantity <= $inv->quantity)){  
       

        if($movement->quantity <= $request->quantity){
            $diff=$request->quantity-$movement->quantity;
            $q=$inv->quantity -$diff;
            Inventory::where('id',$request->item_id)->update(['quantity' => $q]);
        }

        if($movement->quantity > $request->quantity){
            $diff=$movement->quantity - $request->quantity;
            $q=$inv->quantity + $diff;
            Inventory::where('id',$request->item_id)->update(['quantity' => $q]);
        }
  
        $movement->update($data);
       
        return redirect(route('good_movement.index'))->with(['success'=>'Good Movement Updated Successfully']);
        }

        else{
            return redirect(route('good_movement.index'))->with(['error'=>'You have exceeded the Quantity']);
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

        return redirect(route('good_movement.index'))->with(['success'=>'Good Movement  Deleted Successfully']);
    }
}
