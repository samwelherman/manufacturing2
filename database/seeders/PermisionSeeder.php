<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { 
      $data = [
        ['slug' => 'manage-dashboard','name'=>'Dashboard'],
        ['slug' => 'manage-store','name'=>'Store'],
        ['slug' => 'manage-product','name'=>'Sales & Purchase'],
        ['slug' => 'manage-manufacturing','name'=>'Manufacturing'],
        ['slug' => 'manage-movement','name'=>'Movement'],
        ['slug' => 'manage-reports','name'=>'Reports'], 
       
        ['slug' => 'manage-access-control','name'=>'Access Control'], 
    ];
       
     
         
        $data = [
            #1. manage-dashboard permissions
            ['slug' => 'view-dashboard','sys_module_id'=>1],
            ['slug' => 'edit-dashboard','sys_module_id'=>1],
            ['slug' => 'delete-dashboard','sys_module_id'=>1],
            ['slug' => 'add-dashboard','sys_module_id'=>1],
           

            // end manage-User permissions

            #2.start manage-store permissions
            ['slug' => 'view-store','sys_module_id'=>2],
            ['slug' => 'edit-store','sys_module_id'=>2],
            ['slug' => 'delete-store','sys_module_id'=>2],
            ['slug' => 'add-store','sys_module_id'=>2],
            ['slug' => 'confirm-store','sys_module_id'=>2],

     
            // end manage-farmer permissions

            #3.start manage-farming permissions
            ['slug' => 'view-items','sys_module_id'=>3],
            ['slug' => 'edit-items','sys_module_id'=>3],
            ['slug' => 'delete-items','sys_module_id'=>3],
            ['slug' => 'add-items','sys_module_id'=>3],

            ['slug' => 'view-supplier','sys_module_id'=>3],
            ['slug' => 'edit-supplier','sys_module_id'=>3],
            ['slug' => 'delete-supplier','sys_module_id'=>3],
            ['slug' => 'add-supplier','sys_module_id'=>3],

            ['slug' => 'view-purchase','sys_module_id'=>3],
            ['slug' => 'edit-purchase','sys_module_id'=>3],
            ['slug' => 'delete-purchase','sys_module_id'=>3],
            ['slug' => 'add-purchase','sys_module_id'=>3],

            ['slug' => 'approve-purchase','sys_module_id'=>3],
            ['slug' => 'pay-purchase','sys_module_id'=>3],
            ['slug' => 'good-receive','sys_module_id'=>3],
            

            ['slug' => 'view-client','sys_module_id'=>3],
            ['slug' => 'edit-client','sys_module_id'=>3],
            ['slug' => 'delete-client','sys_module_id'=>3],
            ['slug' => 'add-client','sys_module_id'=>3],

            ['slug' => 'view-invoice','sys_module_id'=>3],
            ['slug' => 'edit-invoice','sys_module_id'=>3],
            ['slug' => 'delete-delete','sys_module_id'=>3],
            ['slug' => 'add-invoice','sys_module_id'=>3],

            ['slug' => 'approve-invoice','sys_module_id'=>3],
            ['slug' => 'pay-invoice','sys_module_id'=>3],
            ['slug' => 'delete-delete','sys_module_id'=>3],
            ['slug' => 'add-invoice','sys_module_id'=>3],
            
            // end manage-request permissions

          #2.start manage-orders permissions
          ['slug' => 'view-product','sys_module_id'=>4],
          ['slug' => 'edit-product','sys_module_id'=>4],
          ['slug' => 'delete-product','sys_module_id'=>4],
          ['slug' => 'add-product','sys_module_id'=>4],

          ['slug' => 'view-bom','sys_module_id'=>4],
          ['slug' => 'edit-bom','sys_module_id'=>4],
          ['slug' => 'delete-bom','sys_module_id'=>4],
          ['slug' => 'add-bom','sys_module_id'=>4],

          ['slug' => 'view-production','sys_module_id'=>4],
          ['slug' => 'edit-production','sys_module_id'=>4],
          ['slug' => 'delete-production','sys_module_id'=>4],
          ['slug' => 'add-production','sys_module_id'=>4],

          ['slug' => 'approve-production','sys_module_id'=>4],
          ['slug' => 'release-material','sys_module_id'=>4],
          ['slug' => 'perform-production','sys_module_id'=>4],
          

          ['slug' => 'view-screp','sys_module_id'=>4],
          ['slug' => 'edit-screp','sys_module_id'=>4],
          ['slug' => 'delete-screp','sys_module_id'=>4],
          ['slug' => 'add-screp','sys_module_id'=>4],
          ['slug' => 'clear-screp','sys_module_id'=>4],

          
          // end manage-request permissions
        
          #2.start manage-warehouse permissions
          ['slug' => 'view-movement','sys_module_id'=>5],
          ['slug' => 'edit-movement','sys_module_id'=>5],
          ['slug' => 'delete-movement','sys_module_id'=>5],
          ['slug' => 'add-movement','sys_module_id'=>5],
          ['slug' => 'approve-movement','sys_module_id'=>5],
          
          // end manage-request permissions

              #2.start manage-shop permissions
              ['slug' => 'view-reports','sys_module_id'=>6],
              ['slug' => 'view-inventory','sys_module_id'=>6],
              ['slug' => 'view-namufacturing','sys_module_id'=>6],
             

              
             
              // end manage-request permissions

       

            

           

            #3.start manage-AccessControl permissions  
            ['slug' => 'view-roles','sys_module_id'=>7],
            ['slug' => 'add-roles','sys_module_id'=>7],
            ['slug' => 'edit-roles','sys_module_id'=>7],
            ['slug' => 'delete-roles','sys_module_id'=>7],

            ['slug' => 'view-permission','sys_module_id'=>7],
            ['slug' => 'add-permission','sys_module_id'=>7],
            ['slug' => 'edit-permission','sys_module_id'=>7],
            ['slug' => 'delete-permission','sys_module_id'=>7],

            ['slug' => 'view-user','sys_module_id'=>7],
            ['slug' => 'add-user','sys_module_id'=>7],
            ['slug' => 'edit-user','sys_module_id'=>7],
            ['slug' => 'delete-user','sys_module_id'=>7],

            ['slug' => 'view-dashboard','sys_module_id'=>7],
            

            

 
              // end manage-accounting permissions

  
            
            
       ];

         foreach ($data as $row) {
            Permission::firstOrCreate($row);
         }
    }
}
