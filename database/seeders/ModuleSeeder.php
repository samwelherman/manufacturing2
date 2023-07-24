<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\SystemModule;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = [
            ['slug' => 'manage-dashboard','name'=>'Dashboard'],
            ['slug' => 'manage-store','name'=>'Store'],
            ['slug' => 'manage-product','name'=>'Sales & Purchase'],
            ['slug' => 'manage-manufacturing','name'=>'Manufacturing'],
            ['slug' => 'manage-movement','name'=>'Movement'],
            ['slug' => 'manage-reports','name'=>'Reports'], 
            ['slug' => 'manage-access-control','name'=>'Access Control'], 
        ];
foreach ($data as $row) {
    SystemModule::updateOrCreate($row);
}
    }
}
