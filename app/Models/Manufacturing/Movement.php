<?php

namespace App\Models\Manufacturing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Movement extends Model
{
   


public function get_original_quantity($from_id,$item_id){
             
    $row = DB::table('tbl_store_items')
             ->where('location_id',$from_id)
             ->where('items_id',$item_id)
             ->select('quantity')->first();
            
             
             
             return !empty($row)?$row->quantity:0;
}

public function get_destination_quantity($to_id,$item_id){

    $row = DB::table('tbl_store_items')
    ->where('location_id',$to_id)
    ->where('items_id',$item_id)
    ->select('quantity')->first();
   
   
    
    return !empty($row)?$row->quantity:0;


}

public function check_quantity($from_id,$item_id,$quantity){
          
    $orignal_quantity = $this->get_original_quantity($from_id,$item_id);
    if( $orignal_quantity >= $quantity){
        return true;
    }else{
        return false;
    }
}

public function create_item_movement($from_id=null,$to_id=null,$item_id=null,$quantity=null,$movement_id=null){
    //$result =  false;
    $check_quantity = $this->check_quantity($from_id,$item_id,$quantity);
    if($check_quantity == true){
        $result_original_quantity = $this->get_original_quantity($from_id,$item_id)-$quantity;
        
        $result1 = $this->update_original_store($from_id,$item_id,$result_original_quantity);
        if($result1 == true){
        // start adding remain quantity to movement table
        
        $value=array('remain_balance'=>$result_original_quantity);     
        $this->db->where('movement_id',$movement_id)->update('tbl_item_movement',$value);
        
        // end adding remain quantity to movement table  
            
        $original_destination_quantity = $this->get_destination_quantity($to_id,$item_id);
        if(!empty($original_destination_quantity)){
        $result_destination_quantity = $original_destination_quantity + $quantity;
        $result2 = $this->update_new_store($to_id,$item_id,$result_destination_quantity);
        if($result2 == true){
        
        // start adding new quantity to movement table
        
        $value=array('new_balance'=>$result_destination_quantity);     
        $this->db->where('movement_id',$movement_id)->update('tbl_item_movement',$value);
        
        // end adding new uantity to movement table 
            $result =  true;
        }
        else{
            $result =  false;
        }
        }else{
              $value = array('location_id'=>$to_id,'items_id'=>$item_id,'quantity'=>$quantity);
              $result_id = $this->db->insert('tbl_store_items',$value);
              if(!empty($result_id)){
                $result = true;
            }else{
                $result = false;
            } 
            
        }
        //
        
        }
        
        else{
            $result =  false;
        }
       
  
    }else{
        
        $result =  false;
        
        
    }
    
    return $result;
}

public function create_item_movement1($from_id=null,$to_id=null,$item_id=null,$quantity=null,$movement_id=null){
    //$result =  false;

        // start adding remain quantity to movement table
        
        //$value=array('remain_balance'=>$result_original_quantity);     
        //$this->db->where('movement_id',$movement_id)->update('tbl_item_movement',$value);
        
        // end adding remain uantity to movement table  
            
        $original_destination_quantity = $this->get_destination_quantity($to_id,$item_id);
        if(!empty($original_destination_quantity)){
        $result_destination_quantity = $original_destination_quantity + $quantity;
        $result2 = $this->update_new_store($to_id,$item_id,$result_destination_quantity);
        if($result2 == true){
        
        // start adding new uantity to movement table
        
       // $value=array('new_balance'=>$result_destination_quantity);    
       // DB::table('good_movements')->where('movement_id',$movement_id)->update($value); 
        //$this->db->where('movement_id',$movement_id)->update('tbl_item_movement',$value);
        
        // end adding new uantity to movement table 
            $result =  true;
        }
        else{
            $result =  false;
        }
        }else{
              $value = array('location_id'=>$to_id,'items_id'=>$item_id,'quantity'=>$quantity);
              $result_id = DB::table('tbl_store_items')->insert($value);
             
              if(!empty($result_id)){
                $result = true;
            }else{
                $result = false;
            } 
            
        }
        //
        
     
       
 
    
    return $result;
}

public function update_original_store($from_id,$item_id,$quantity){
            $result = false;
            
            $value=array('quantity'=>$quantity);
            $result_id = DB::table('tbl_store_items')
            ->where('location_id',$from_id)
            ->where('items_id',$item_id)
            ->update($value);
            
            if(!empty($result_id)){
                $result = true;
            }else{
                $result = false;
            }
            return $result;
}

public function update_new_store($to_id,$item_id,$quantity){
            $result = false;
        
            $value=array('quantity'=>$quantity);
            $result_id = DB::table('tbl_store_items')
            ->where('location_id',$to_id)
            ->where('items_id',$item_id)
            ->update($value);

            
            if(!empty($result_id)){
                  $result = true;
            }else{
                  $result = false;
            }
          return $result;
}


}
