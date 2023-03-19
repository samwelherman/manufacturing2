<?php

namespace App\Http\Controllers\POS;

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
use App\Models\Manufacturing\Movement;

use App\Models\POS\PurchaseHistory;
use App\Models\Location;

class ItemsController extends Controller
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
    public function index(Request $request)
    {
        //
          if ($request->ajax()) {
            $data = Items::select('*')->where('added_by',auth()->user()->added_by)->where('type',3);
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
                            return 'Manufacturing';
                        }
                    })
                          ->editColumn('cost_price', function ($row) {
                        return number_format($row->cost_price,2);
                   })
                       ->editColumn('sales_price', function ($row) {
                        return number_format($row->sales_price,2);
                   })
                     ->editColumn('quantity', function ($row) {
                        return number_format($row->quantity,2);
                   })

                    ->editColumn('action', function($row){
               $action=' <div class="form-inline"><a href="'.route('items.edit',$row->id).'"  title="Edit " class="list-icons-item text-primary"  > <i class="icon-pencil7"></i> </a>&nbsp
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
        $location = Location::where('type',3)->where('added_by',auth()->user()->added_by)->get();;

        return view('pos.items.index',compact('location'));
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

      //  $this->movement_model->create_item_movement1('',$request->location,$items->id,$request->quantity,'');


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

        return redirect(route('items.index'))->with(['success'=>'Created Successfully']);
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
       return view('pos.items.update',compact('id','location'));
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
       $location = Location::where('type',3)->where('added_by',auth()->user()->added_by)->get();;

    return view('pos.items.index',compact('data','id','location'));
    
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
        
        //$this->movement_model->create_item_movement1('',$request->location,$id,$request->quantity-$item->quantity,'');

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
    return redirect(route('items.index'))->with(['success'=>'Updated Successfully']);;
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


    return redirect(route('items.index'))->with(['success'=>'Updated Successfully']);;
    }


}
