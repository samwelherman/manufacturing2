<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\FieldStaff;
use App\Models\GoodMovement;
use App\Models\Manufacturing\Movement;
use App\Models\Inventory;
use  App\Models\POS\Items;
use App\Models\Location;
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
     if(($request->source_location == $request->destination_location)){  
    return redirect(route('good_movement.index'))->with(['error'=>'You have chosen the same location']);

}

else{
   $data = $request->all();
   $data['added_by']=auth()->user()->added_by;

   $data['item_id']=$request->item_id;
   $data['source_location'] = $request->source_location;
   $data['destination_location'] = $request->destination_location;
   $data['quantity']=$request->quantity;




if (!empty($data['items_id'])) {
         $item_info = Items::find($request->item_id);
 }
    
     $result = $this->movement_model->check_quantity($data['source_location'],$data['item_id'],$data['quantity']);
     
     if($result == true){
    
        $movement= GoodMovement::create($data);
        if(!empty($movement)){
            return redirect(route('good_movement.index'))->with(['success'=>'Good Movement Created Successfully']);
       //saved
         
        }
        else{
            return redirect(route('good_movement.index'))->with(['error'=>'Good Movement Not Saved']);

        }
        
     }
     else{   
        return redirect(route('good_movement.index'))->with(['error'=>'You have exceeded the Quantity']);

       
              
     }
  
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
        $inventory= Items::all();
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

    //  $purchase_info = $this->movement_model->check_by(array('movement_id' => $id), 'tbl_item_movement');
    //  $purchase_id = $id;
    //  $this->movement_model->save($data, $id);
    //  $action = ('movement_updated');
    //  $msg = lang('movement_updated');



        $movement=GoodMovement::find($id);

     if(($request->source_location == $request->destination_location)){  
    return redirect(route('good_movement.index'))->with(['error'=>'You have chosen the same location']);

}

else{
        $data = $request->all();
        $data['added_by']=auth()->user()->added_by;

        $inv=Inventory::where('id',$request->item_id)->first();
 
        if(($request->quantity <= $inv->quantity)){  
        $movement->update($data);
        return redirect(route('good_movement.index'))->with(['success'=>'Good Movement Updated Successfully']);
        }

        else{
            return redirect(route('good_movement.index'))->with(['error'=>'You have exceeded the Quantity']);
        }
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

 public function approve($id)
    {
        //

                
        //get gud issue
        $data =  GoodMovement::find($id);
        
        $movement_table = $this->movement_model->create_item_movement($data->source_location,$data->destination_location,$data->item_id,$data->quantity,$id);
        
        if($movement_table == true){
            
            $list['status']='1';
            $data->update($list);

            return redirect(route('good_movement.index'))->with(['success'=>'Good Movement Approved Successfully']);

            
        }else{
            
            return redirect(route('good_movement.index'))->with(['success'=>'not confirmed no enough items']);

        }
        
      
    }

}
