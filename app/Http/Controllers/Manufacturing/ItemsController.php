<?php

namespace App\Http\Controllers\Manufacturing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\ButtonsServiceProvider;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use  App\Models\POS\Items;
use App\Models\POS\Activity;
use App\Models\POS\PurchaseHistory;
use App\Models\Location;

class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
          if ($request->ajax()) {
            $data = Items::select('*')->where('added_by',auth()->user()->added_by)->where('type',2);
            return Datatables::of($data)
                    ->addIndexColumn()
                        ->editColumn('type', function ($row) {
                        if ($row->type == 1) {
                            return 'Inventory';
                        }
                        elseif($row->type == 4) {
                            return 'Service';
                        }
                        
                        else {
                            return 'Manufactured Product';
                        }
                    })
               

                    ->editColumn('action', function($row){
               $action=' <div class="form-inline"><a href="'.route('product_items.edit',$row->id).'"  title="Edit " class="list-icons-item text-primary"  > <i class="icon-pencil7"></i> </a>&nbsp
                    <a href="javascript:void(0)"   onclick = "deleteItem('.$row->id.')"  title="Delete " class="list-icons-item text-danger delete" > <i class="icon-trash"></i> </a>&nbsp
       <div class="dropdown"><a href="#" class="list-icons-item dropdown-toggle text-teal" data-toggle="dropdown"><i class="icon-cog6"></i></a><div class="dropdown-menu">
               <a href="#"   onclick = "model('.$row->id.')"  class="nav-link" title="Update"  data-toggle="modal" data-target="#appFormModal"> Update Quantity</a>
                                     </div></div>
                                 
                                </div>';
                      
                    return $action;   
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('manufacturing.items.index');
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
        $data['added_by'] = auth()->user()->added_by;
        $items = Items::create($data);

if(!empty($items)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
       'user_id'=>auth()->user()->id,
                            'module_id'=>$items->id,
                             'module'=>'Inventory',
                            'activity'=>"Inventory " .  $items->name. "  Created",
                        ]
                        );                      
       }

        return redirect(route('product_items.index'))->with(['success'=>'Created Successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $location = Location::where('type',3)->where('added_by',auth()->user()->added_by)->get();;
       return view('manufacturing.items.update',compact('id','location'));
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
       $data=Items::find($id);
    return view('manufacturing.items.index',compact('data','id'));
    
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
     $item=Items::find($id);
     $data = $request->all();
        $item->update($data);

if(!empty($item)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
       'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Inventory',
                            'activity'=>"Inventory " .  $item->name. "  Updated",
                        ]
                        );                      
       }
    return redirect(route('product_items.index'))->with(['success'=>'Updated Successfully']);;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Request $request)
    {
        //
  $item=Items::find($id);
     $name=$item->name;
    $item->delete();


if(!empty($item)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
       'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Inventory',
                            'activity'=>"Inventory " .  $name. "  Deleted",
                        ]
                        );                      
       }
return response()->json(['success'=>'Deleted Successfully']);
    }

 public function update_quantity(Request $request)
    {
        //
     $item=Items::find($request->id);
     $data['quantity'] = $item->quantity + $request->quantity;
        $item->update($data);

     $lists= array(
                            'quantity' =>   $request->quantity,
                          'price' => $item->cost_price,
                             'item_id' =>$item->id,
                               'added_by' => auth()->user()->added_by,
                             'purchase_date' =>   $request->purchase_date,
                             'location' => $request->location,
                            'type' =>   'Purchases');
                           
                         PurchaseHistory ::create($lists);   

                    $loc=Location::find($request->location);
                        $lq['quantity']=$loc->quantity + $request->quantity;
                        $loc->update($lq);


    return redirect(route('product_items.index'))->with(['success'=>'Updated Successfully']);;
    }


}
