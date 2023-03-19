<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\FieldStaff;
use App\Models\Service;
use App\Models\User;
use App\Models\ServiceInventory;
use App\Models\ServiceItem;
use App\Models\ServiceType;
use App\Models\Truck;
use App\Models\Inventory;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $service=Service::where('added_by',auth()->user()->added_by)->get();
        $truck = Truck::where('disabled','0')->where('truck_type','Horse')->where('added_by',auth()->user()->added_by)->get(); 
       $staff=FieldStaff::where('added_by',auth()->user()->added_by)->get();
       //$staff=User::where('id','!=','1')->get();  
       $i_name = Inventory::where('added_by',auth()->user()->added_by)->get();
      $name =ServiceType::where('added_by',auth()->user()->added_by)->get();
       return view('inventory.service',compact('service','truck','staff','i_name','name'));
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
        $data['date']=$request->date;
        $data['truck']=$request->truck;    
        $data['reading']=$request->reading;
        $data['mechanical']=$request->mechanical;
        $data['history']=$request->history;
        $data['major']=$request->major;
        $data['status']='0';

        $driver=Truck::where('id',$request->truck)->first();
        $data['driver']=$driver->driver;
        $data['added_by']= auth()->user()->added_by;
        $data['truck_name']=$driver->truck_name;
       $data['reg_no']=$driver->reg_no;
        $service = Service::create($data);
        
       

        $nameArr =$request->minor ;

        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){


                    $items = array(
                        'minor' => $nameArr[$i],
                        'truck' =>    $data['truck'],
                           'order_no' => $i,
                           'added_by' => auth()->user()->added_by,
                        'service_id' =>$service->id);
                       
                    ServiceItem::create($items);  ;
    
    
                }
            }
           
        }   


 $itemArr =$request->item_name ;
    $qtyArr =$request->quantity ;
  
        if(!empty($itemArr)){
            for($i = 0; $i < count($itemArr); $i++){
                if(!empty($itemArr[$i])){

                    $report = array(
                        'item_name' => $itemArr[$i],
                          'quantity' => $qtyArr[$i],
                           'order_no' => $i,
                           'added_by' => auth()->user()->added_by,
                        'service_id' =>$service->id);
                       
                   ServiceInventory::create($report);  ;
    
    
                }
            }
           
        }     

        return redirect(route('service.index'))->with(['success'=>'Service Created Successfully']);
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
        $data=Service::find($id);
        $items=ServiceItem::where('service_id',$id)->get();
       $inv=ServiceInventory::where('service_id',$id)->get();
        $truck = Truck::where('disabled','0')->where('truck_type','Horse')->where('added_by',auth()->user()->added_by)->get(); 
       $staff=FieldStaff::where('added_by',auth()->user()->added_by)->all();
       //$staff=User::where('id','!=','1')->get();  
       $i_name = Inventory::where('added_by',auth()->user()->added_by)->get();
      $name =ServiceType::where('added_by',auth()->user()->added_by)->get();
       return view('inventory.service',compact('data','truck','staff','id','items','i_name','inv','name'));
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
        $service =  Service::find($id);

        $data['date']=$request->date;
        $data['truck']=$request->truck;    
        $data['reading']=$request->reading;
        $data['mechanical']=$request->mechanical;
        $data['history']=$request->history;
        $data['major']=$request->major;

        $driver=Truck::where('id',$request->truck)->first();
        $data['driver']=$driver->driver;
        $data['added_by']= auth()->user()->added_by;
        $data['truck_name']=$driver->truck_name;
        $data['reg_no']=$driver->reg_no;
        $service->update($data);
             

        $nameArr =$request->minor ;
        $remArr = $request->removed_id ;
        $expArr = $request->saved_id ;

        if (!empty($remArr)) {
            for($i = 0; $i < count($remArr); $i++){
               if(!empty($remArr[$i])){        
                ServiceItem::where('id',$remArr[$i])->delete();        
                   }
               }
           }


        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){


                    $items = array(
                        'minor' => $nameArr[$i],
                        'truck' =>    $data['truck'],
                           'order_no' => $i,
                           'added_by' => auth()->user()->added_by,
                        'service_id' =>$id);
                       
                        if(!empty($expArr[$i])){
                            ServiceItem::where('id',$expArr[$i])->update($items);  
      
      }
      else{
        ServiceItem::create($items);     
      }
                   
    
    
                }
            }
           
        }    


 $itemArr =$request->item_name ;
$qtyArr =$request->quantity ;
   $invremArr = $request->removed_inv_id ;
        $invexpArr = $request->saved_inv_id ;

        if (!empty($invremArr)) {
            for($i = 0; $i < count($invremArr); $i++){
               if(!empty($invremArr[$i])){        
                ServiceInventory::where('id',$invremArr[$i])->delete();        
                   }
               }
           }

        if(!empty($itemArr)){
            for($i = 0; $i < count($itemArr); $i++){
                if(!empty($itemArr[$i])){

                    $report = array(
                        'item_name' => $itemArr[$i],
                           'quantity' => $qtyArr[$i],
                           'order_no' => $i,
                           'added_by' => auth()->user()->added_by,
                        'service_id' =>$id);

                    if(!empty($invexpArr[$i])){
                            ServiceInventory::where('id',$invexpArr[$i])->update($report);  
      
      }
      else{
     ServiceInventory::create($report);  ; 
      }
                       
                  
    
    
                }
            }
           
        }     

        return redirect(route('service.index'))->with(['success'=>'Service Updated Successfully']);
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
        ServiceItem::where('service_id', $id)->delete();
        ServiceInventory::where('service_id', $id)->delete();

        $service =  Service::find($id);
        $service->delete();

 
        return redirect(route('service.index'))->with(['success'=>'Service Deleted Successfully']);
    }

    public function approve($id)
    {
        //
        $service =  Service::find($id);
        $data['status'] = 1;
        $service->update($data);

       $inventory=ServiceInventory::where('service_id',$id)->get();
     foreach($inventory as $inv){
     $list=Inventory::find($inv->item_name);
      $q=$list->quantity -$inv->quantity;
    Inventory::where('id',$inv->item_name)->update(['quantity' => $q]);
}
        return redirect(route('service.index'))->with(['success'=>'Service Completed Successfully']);
    }


}
