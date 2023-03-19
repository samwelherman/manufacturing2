<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Models\AccountCodes;
use App\Models\JournalEntry;
use App\Models\FieldStaff;
use App\Models\User;
use App\Models\POS\GoodIssue;
use App\Models\POS\GoodIssueItem;
use App\Models\POS\InvoiceHistory;
use App\Models\POS\PurchaseHistory;
use App\Models\Location;
use App\Models\LocationManager;
use App\Models\Truck;
use App\Models\POS\Items;
use App\Models\POS\Activity;
use Illuminate\Http\Request;

class GoodIssueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $issue= GoodIssue::where('added_by',auth()->user()->added_by)->get();;
        //$location=Location::where('type',3)->where('added_by',auth()->user()->added_by)->get();;
         $location= LocationManager::where('manager',auth()->user()->id)->where('disabled','0')->get();
        $truck=Truck::where('added_by',auth()->user()->added_by)->where('disabled',0)->get();;
        $inventory= Items::whereIn('type', [1,4])->where('added_by',auth()->user()->added_by)->get();;
        //$staff=FieldStaff::where('added_by',auth()->user()->added_by)->get();;
         $staff=User::where('added_by',auth()->user()->added_by)->get();;
       return view('pos.purchases.good_issue',compact('issue','inventory','location','staff','truck'));
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
        $data['location']=$request->location;    
        $data['staff']=$request->staff;
        $data['truck_id']=$request->truck_id;
        $data['name']=$request->name;
        $data['status']= 0;
        $data['added_by']= auth()->user()->added_by;

        $issue = GoodIssue::create($data);
        
       

        $nameArr =$request->item_id ;
        $qtyArr =$request->quantity ;

        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){


                    $items = array(
                        'item_id' => $nameArr[$i],
                        'status' => 0,
                        'location' => $request->location,
                         'truck_id' => $request->truck_id,
                        'quantity' =>    $qtyArr[$i],
                           'order_no' => $i,
                           'added_by' => auth()->user()->added_by,
                        'issue_id' =>$issue->id);

                    
                   GoodIssueItem::create($items);

                   $loc=Truck::find($request->truck_id);
                  $itm=Items::find($nameArr[$i]);

               if(!empty($issue)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
                           'user_id'=>auth()->user()->id,
                            'module_id'=>$issue->id,
                             'module'=>'Good Issue',
                            'activity'=>"Good issue for ".$itm->name . " to  " .$loc->reg_no ."  with reference " .$issue->name ." is Created",
                        ]
                        );                      
       }

    
                }
            }
           
        }    


                return redirect(route('pos_issue.index'))->with(['success'=>'Good Issue Created Successfully']);
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
        $data=GoodIssue::find($id);
         //$location=Location::where('type',3)->where('added_by',auth()->user()->added_by)->get();;
         $location=LocationManager::where('manager',auth()->user()->id)->where('disabled','0')->get();
        $inventory= Items::whereIn('type', [1,4])->where('added_by',auth()->user()->added_by)->get();;
         $truck=Truck::where('added_by',auth()->user()->added_by)->where('disabled',0)->get();;
       //$staff=FieldStaff::where('added_by',auth()->user()->added_by)->get();;
         $staff=User::where('added_by',auth()->user()->added_by)->get();;
        $items=GoodIssueItem::where('issue_id',$id)->get();
       return view('pos.purchases.good_issue',compact('items','inventory','location','staff','data','id','truck'));
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

        $issue=GoodIssue::find($id);

        $data['date']=$request->date;
        $data['location']=$request->location;    
        $data['staff']=$request->staff;
        $data['name']=$request->name;
        $data['truck_id']=$request->truck_id;
        $data['added_by']= auth()->user()->added_by;
        $issue->update($data);
        
       
        $nameArr =$request->item_id ;
        $qtyArr =$request->quantity ;
        $remArr = $request->removed_id ;
        $expArr = $request->saved_id ;




           
        if (!empty($remArr)) {
            for($i = 0; $i < count($remArr); $i++){
               if(!empty($remArr[$i])){        
               GoodIssueItem::where('id',$remArr[$i])->delete();   
                            
                   }
               }
           }

           



        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){


                    $items = array(
                        'item_id' => $nameArr[$i],
                        'location' => $request->location,
                      'truck_id' => $request->truck_id,
                        'quantity' =>    $qtyArr[$i],
                           'order_no' => $i,
                           'added_by' => auth()->user()->added_by,
                        'issue_id' =>$id);
                       
                    
                   
                            if(!empty($expArr[$i])){
                                GoodIssueItem::where('id',$expArr[$i])->update($items);                              
                             }
                          else{
                         GoodIssueItem::create($items);  
                       
                          }                         
                     
                   $loc=Truck::find($request->truck_id);
                  $itm=Items::find($nameArr[$i]);

               if(!empty($issue)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
                           'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Good Issue',
                            'activity'=>"Good issue for ".$itm->name . " to  " .$loc->reg_no ."  with reference " .$issue->name ." is Updated",
                        ]
                        );                      
       }

    
                }
            }
           
        }    

                return redirect(route('pos_issue.index'))->with(['success'=>'Good Issue Updated Successfully']);
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
        GoodIssueItem::where('issue_id', $id)->delete();

        $issue =  GoodIssue::find($id);

          $items= GoodIssueItem::where('issue_id',$id)->get();
          foreach($items as $i){

                   $loc=Truck::find($i->truck_id);
                  $itm=Items::find($i->item_id);

               if(!empty($issue)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
                               'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Good Issue',
                             'activity'=>"Good issue for ".$itm->name . " to  " .$loc->reg_no ."  with reference " .$issue->name ." is Deleted",
                        ]
                        );                      
       }
}

        $issue->delete();

                return redirect(route('pos_issue.index'))->with(['success'=>'Good Issue Deleted Successfully']);
    }

    public function approve($id){
        //

 $item=GoodIssueItem::where('issue_id',$id)->get();
 $total=0;

foreach($item as $i){

$issue=GoodIssue::find($id);


 $inv=Items::where('id',$i->item_id)->first();
 $q=$inv->quantity - $i->quantity;
Items::where('id',$i->item_id)->update(['quantity' => $q]);


$total+= $inv->cost_price *  $i->quantity;


 $loc=Truck::find($i->truck_id);
                  $itm=Items::find($i->item_id);

               if(!empty($issue)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
                          'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Good Issue',
                             'activity'=>"Good issue for ".$itm->name . " to  " .$loc->reg_no ."  with reference " .$issue->name ." is Approved",
                        ]
                        );                      
       }




  $d=$issue->date;

$codes= AccountCodes::where('account_name','Truck Maintenance and Service')->where('added_by', auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $codes->id;
   $date = explode('-',$d);
  $journal->date =   $d ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'pos_inventory_issue';
  $journal->name = 'POS Good Issue of Inventory ';
  $journal->income_id= $id;
  $journal->debit =$inv->cost_price *  $i->quantity;
  $journal->truck_id= $i->truck_id;
 $journal->added_by=auth()->user()->added_by;
$journal->notes="POS Inventory Issued to " . $loc->reg_no ."  with reference " .$issue->name;
  $journal->save();

  $cr= AccountCodes::where('account_name','Inventory')->where('added_by',auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $cr->id;
  $date = explode('-',$d);
  $journal->date =   $d ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'pos_inventory_issue';
  $journal->name = 'POS Good Issue of Inventory ';
  $journal->income_id= $id;
  $journal->credit = $inv->cost_price *  $i->quantity;
  $journal->truck_id= $i->truck_id;
 $journal->added_by=auth()->user()->added_by;
 $journal->notes="POS Inventory Issued to " . $loc->reg_no ."  with reference " .$issue->name;
  $journal->save();

} 

GoodIssue::where('id',$id)->update(['status' => '1']);;
GoodIssueItem::where('issue_id',$id)->update(['status' => '1']);;

       
        return redirect(route('pos_issue.index'))->with(['success'=>'Good Issue Approved Successfully']);
    }


    public function findQuantity(Request $request)
    {
 
$item=$request->item;
$location=$request->location;

$item_info=Items::where('id', $item)->first();  
$location_info=Location::find($request->location);
 if ($item_info->quantity > 0) {

$pqty= PurchaseHistory::where('item_id', $item)->where('location',$location)->where('type', 'Purchases')->where('added_by',auth()->user()->added_by)->sum('quantity');   
$dn= PurchaseHistory::where('item_id', $item)->where('location',$location)->where('type', 'Debit Note')->where('added_by',auth()->user()->added_by)->sum('quantity');  

$good=GoodIssueItem::where('item_id',$item)->where('location',$location)->where('status',1)->where('added_by',auth()->user()->added_by)->sum('quantity');

$sqty= InvoiceHistory::where('item_id', $item)->where('location',$location)->where('type', 'Sales')->where('added_by',auth()->user()->added_by)->sum('quantity'); 
 $cn= InvoiceHistory::where('item_id', $item)->where('location',$location)->where('type', 'Credit Note')->where('added_by',auth()->user()->added_by)->sum('quantity');  

$qty=$pqty-$dn;
$inv=$sqty-$cn ;

$quantity=$qty - $good - $inv;


 if ($quantity > 0) {

if($request->id >  $quantity){
$price="You have exceeded your Stock. Choose quantity between 1.00 and ".  number_format($quantity,2) ;
}
else if($request->id <=  0){
$price="Choose quantity between 1.00 and ".  number_format($quantity,2) ;
}
else{
$price='' ;
 }

}

else{
$price=$location_info->name . " Stock Balance  is Zero." ;

}


}

else{
$price="Your Stock Balance is Zero." ;

}

                return response()->json($price);                      
 
    }

    public function findService(Request $request)
    {

 switch ($request->id) {
        case 'Service':
              $type_id= Service::where('status','=','0')->get();                                                                                    
               return response()->json($type_id);
                      
            break;

       case 'Maintenance':
           $type_id= Maintainance::where('status','=','0')->get(); 
                return response()->json($type_id);
                      
            break;

    

    }

}
    

public function discountModal(Request $request)
{
             $id=$request->id;
             $type = $request->type;
              if($type == 'issue'){
                $data=GoodIssueItem::where('issue_id',$id)->get();
                return view('pos.purchases.view_issue',compact('id','data'));
  }

             }

}
