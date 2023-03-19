<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\AccountType;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\User_Roles;
use App\Models\CompanyRoles;
use App\Models\Role;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::INDEX;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required'],
            'address' => ['required', 'string', 'max:255'],
            'register_as' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        
        $user =  User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'user_type' => 'customer',
            'password' => Hash::make($data['password']),
        ]);
        User::where('id',$user->id)->update(['added_by'=>$user->id]);

        $user->roles()->attach($data['register_as']);
        
        // AccountType::create(['added_by'=>$user->id,'type'=>'Assets','value'=>10000]);
        // AccountType::create(['added_by'=>$user->id,'type'=>'Liability','value'=>20000]);
        // AccountType::create(['added_by'=>$user->id,'type'=>'Equity','value'=>30000]);
        // AccountType::create(['added_by'=>$user->id,'type'=>'Expense','value'=>40000]);
        // AccountType::create(['added_by'=>$user->id,'type'=>'Income','value'=>50000]);
        
        //shule  accounting
        if($data['register_as'] = 64  ){
                
                //for school roles 
                
                $account_groupSchoolOld = DB::table('gl_account_group_school')->get();
        
                foreach($account_groupSchoolOld as $row){
            
            
                
                DB::table('gl_account_group')->insert([
                    
                    'group_id' => $row->group_id,
                    'name' => $row->name,
                    'class' => $row->class,
                    'type' => $row->type,
                    'order_no' => $row->order_no,
                    'added_by' => $user->id,
                    
                ]);
                
            
                }
                
                
                $account_typeSchoolOld = DB::table('gl_account_type_school')->get();
                
                foreach($account_typeSchoolOld as $row){
                    
                   
                        
                        DB::table('gl_account_type')->insert([
                            // 'account_type_id' => $row->account_type_id,
                            'value' => $row->value,
                            'type' => $row->type,
                            'added_by' => $user->id,
                            
                        ]);
                        
                    
                }
                
                $account_codesSchoolOld = DB::table('gl_account_codes_school')->get();
                
                foreach($account_codesSchoolOld as $row){
                    
                    
                        
                        DB::table('gl_account_codes')->insert([
                            
                            'account_codes' => $row->account_codes,
                            'account_name' => $row->account_name,
                            'account_group' => $row->account_group,
                            'account_type' => $row->account_type,
                            'account_status' => $row->account_status,
                            'allow_manual' => $row->allow_manual,
                            'account_id' => $row->account_id,
                            'order_no' => $row->order_no,
                            'added_by' => $user->id,
                            
                        ]);
                        
                       
                    
                }
                
                $account_classSchoolOld = DB::table('gl_account_class_school')->get();
                
                foreach($account_classSchoolOld as $row){
                    
                    
                        
                        DB::table('gl_account_class')->insert([
                            
                            'class_id' => $row->class_id,
                            'class_name' => $row->class_name,
                            'class_type' => $row->class_type,
                            'order_no' => $row->order_no,
                            'added_by' => $user->id,
                            
                        ]);
                     
                    
                }
        
        }
        
        //manufacture role
        
        elseif($data['register_as'] = 72 || $data['register_as'] = 46 ){
                
                //for school roles 
                
                $account_groupManuOld = DB::table('gl_account_group_manufact')->get();
        
                foreach($account_groupManuOld as $row){
            
            
                
                    DB::table('gl_account_group')->insert([
                        
                        'group_id' => $row->group_id,
                        'name' => $row->name,
                        'class' => $row->class,
                        'type' => $row->type,
                        'order_no' => $row->order_no,
                        'added_by' => $user->id,
                        
                    ]);
                
            
                }
                
                
                $account_typeManuOld = DB::table('gl_account_typeOld')->get();
                
                foreach($account_typeManuOld as $row){
                    
                   
                        
                        DB::table('gl_account_type')->insert([
                            // 'account_type_id' => $row->account_type_id,
                            'value' => $row->value,
                            'type' => $row->type,
                            'added_by' => $user->id,
                            
                        ]);
                        
                    
                }
                
                $account_codesManuOld = DB::table('gl_account_codes_manufact')->get();
                
                foreach($account_codesManuOld as $row){
                    
                    
                        
                        DB::table('gl_account_codes')->insert([
                            
                            'account_codes' => $row->account_codes,
                            'account_name' => $row->account_name,
                            'account_group' => $row->account_group,
                            'account_type' => $row->account_type,
                            'account_status' => $row->account_status,
                            'allow_manual' => $row->allow_manual,
                            'account_id' => $row->account_id,
                            'order_no' => $row->order_no,
                            'added_by' => $user->id,
                            
                        ]);
                        
                       
                    
                }
                
                $account_classManuOld = DB::table('gl_account_classOld')->get();
                
                foreach($account_classManuOld as $row){
                    
                    
                        
                        DB::table('gl_account_class')->insert([
                            
                            'class_id' => $row->class_id,
                            'class_name' => $row->class_name,
                            'class_type' => $row->class_type,
                            'order_no' => $row->order_no,
                            'added_by' => $user->id,
                            
                        ]);
                     
                    
                }
        
        }
        
        //courier roles
        elseif($data['register_as'] = 34 || $data['register_as'] = 50 ){
                
                //for courier roles 
                
                $account_groupCourOld = DB::table('gl_account_group_cour')->get();
        
                foreach($account_groupCourOld as $row){
            
            
                
                    DB::table('gl_account_group')->insert([
                        
                        'group_id' => $row->group_id,
                        'name' => $row->name,
                        'class' => $row->class,
                        'type' => $row->type,
                        'order_no' => $row->order_no,
                        'added_by' => $user->id,
                        
                    ]);
                
            
                }
                
                
                $account_typeCourOld = DB::table('gl_account_type_courier')->get();
                
                foreach($account_typeCourOld as $row){
                    
                   
                        
                        DB::table('gl_account_type')->insert([
                            // 'account_type_id' => $row->account_type_id,
                            'value' => $row->value,
                            'type' => $row->type,
                            'added_by' => $user->id,
                            
                        ]);
                        
                    
                }
                
                $account_codesCourOld = DB::table('gl_account_codes_courier')->get();
                
                foreach($account_codesCourOld as $row){
                    
                    
                        
                        DB::table('gl_account_codes')->insert([
                            
                            'account_codes' => $row->account_codes,
                            'account_name' => $row->account_name,
                            'account_group' => $row->account_group,
                            'account_type' => $row->account_type,
                            'account_status' => $row->account_status,
                            'allow_manual' => $row->allow_manual,
                            'account_id' => $row->account_id,
                            'order_no' => $row->order_no,
                            'added_by' => $user->id,
                            
                        ]);
                        
                       
                    
                }
                
                $account_classCourOld = DB::table('gl_account_class_courie')->get();
                
                foreach($account_classCourOld as $row){
                    
                    
                        
                        DB::table('gl_account_class')->insert([
                            
                            'class_id' => $row->class_id,
                            'class_name' => $row->class_name,
                            'class_type' => $row->class_type,
                            'order_no' => $row->order_no,
                            'added_by' => $user->id,
                            
                        ]);
                     
                    
                }
        
        }
        
        //logistic role
        elseif($data['register_as'] = 13){
                
                //for courier roles 
                
                $account_groupCourOld = DB::table('gl_account_grouplogis')->get();
        
                foreach($account_groupCourOld as $row){
            
            
                
                    DB::table('gl_account_group')->insert([
                        
                        'group_id' => $row->group_id,
                        'name' => $row->name,
                        'class' => $row->class,
                        'type' => $row->type,
                        'order_no' => $row->order_no,
                        'added_by' => $user->id,
                        
                    ]);
                
            
                }
                
                
                $account_typeCourOld = DB::table('gl_account_typelogis')->get();
                
                foreach($account_typeCourOld as $row){
                    
                   
                        
                        DB::table('gl_account_type')->insert([
                            // 'account_type_id' => $row->account_type_id,
                            'value' => $row->value,
                            'type' => $row->type,
                            'added_by' => $user->id,
                            
                        ]);
                        
                    
                }
                
                $account_codesCourOld = DB::table('gl_account_codeslogis')->get();
                
                foreach($account_codesCourOld as $row){
                    
                    
                        
                        DB::table('gl_account_codes')->insert([
                            
                            'account_codes' => $row->account_codes,
                            'account_name' => $row->account_name,
                            'account_group' => $row->account_group,
                            'account_type' => $row->account_type,
                            'account_status' => $row->account_status,
                            'allow_manual' => $row->allow_manual,
                            'account_id' => $row->account_id,
                            'order_no' => $row->order_no,
                            'added_by' => $user->id,
                            
                        ]);
                        
                       
                    
                }
                
                $account_classCourOld = DB::table('gl_account_classlogis')->get();
                
                foreach($account_classCourOld as $row){
                    
                    
                        
                        DB::table('gl_account_class')->insert([
                            
                            'class_id' => $row->class_id,
                            'class_name' => $row->class_name,
                            'class_type' => $row->class_type,
                            'order_no' => $row->order_no,
                            'added_by' => $user->id,
                            
                        ]);
                     
                    
                }
        
        }
        
        
        else{
            
            
            $account_groupOld = DB::table('gl_account_groupOld')->get();
        
            foreach($account_groupOld as $row){
                
                
                    
                    DB::table('gl_account_group')->insert([
                        
                        'group_id' => $row->group_id,
                        'name' => $row->name,
                        'class' => $row->class,
                        'type' => $row->type,
                        'order_no' => $row->order_no,
                        'added_by' => $user->id,
                        
                    ]);
                    
                
            }
            
            
            $account_typeOld = DB::table('gl_account_typeOld')->get();
            
            foreach($account_typeOld as $row){
                
               
                    
                    DB::table('gl_account_type')->insert([
                        
                        'account_type_id' => $row->account_type_id,
                        'value' => $row->value,
                        'type' => $row->type,
                        'added_by' => $user->id,
                        
                    ]);
                    
                
            }
            
            $account_codesOld = DB::table('gl_account_codesOld')->get();
            
            foreach($account_codesOld as $row){
                
                
                    
                    DB::table('gl_account_codes')->insert([
                        
                        'account_codes' => $row->account_codes,
                        'account_name' => $row->account_name,
                        'account_group' => $row->account_group,
                        'account_type' => $row->account_type,
                        'account_status' => $row->account_status,
                        'allow_manual' => $row->allow_manual,
                        'account_id' => $row->account_id,
                        'order_no' => $row->order_no,
                        'added_by' => $user->id,
                        
                    ]);
                    
                   
                
            }
            
            $account_classOld = DB::table('gl_account_classOld')->get();
            
            foreach($account_classOld as $row){
                
                
                    
                    DB::table('gl_account_class')->insert([
                        
                        'class_id' => $row->class_id,
                        'class_name' => $row->class_name,
                        'class_type' => $row->class_type,
                        'order_no' => $row->order_no,
                        'added_by' => $user->id,
                        
                    ]);
                 
                
            }
        }

        return $user;
    }
    
    public function affiliate_register(){
        
        return view('auth.affiliate_register');
    }
    
    public function affiliate_register_store(Request $request){
        
        $this->validate($request,[
            
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required'],
            'address' => ['required', 'string', 'max:255'],
            'register_as' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            
        ]); 
        
        $user =  User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'address' => $request['address'],
            'user_type' => 'affiliate',
            'password' => Hash::make($request['password']),
        ]);
        
        if($user){
            
            $affiliate = "EMA0".$user->id;


            User::where('id',$user->id)->update(['added_by'=>$user->id, 'affiliate_no' => $affiliate]);
        
            $roles_added2 = Role::where('slug', $request['register_as'])->first();
                    
            $role_user_id =  $roles_added2->id;
    
            $user->roles()->attach($role_user_id);
            
            return redirect()->route('login');

        }
        else{
            
                    return back()->with('error', "Registration Failed, Please Try Again Later.");
        }
        
        
    }
}
