<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Details\UserDetails;
use App\Models\System;


class UserDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        //$user_id=auth()->user()->id;
        //$user=User::find($user_id);

        return view('home');
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

        
      if ($request->hasFile('files')) {
        $file=$request->file('files');
        $fileType=$file->getClientOriginalExtension();
        $fileName=rand(1,1000).date('dmyhis').".".$fileType;
        $logo=$fileName;
        $photo->move('public/assets/img/logo', $fileName );

        $data['logo'] = $logo;
    }else{
        $data['logo'] = null;
    }
        UserDetails::create($data);
        
        
           $data1['name'] = $request->company_name;
        $data1['tin'] = $request->tin;
        $data1['email'] = $request->email;
        $data1['address'] = $request->address;
        
        
					 $data1['added_by'] = auth()->user()->added_by;
      if ($request->hasFile('picture')) {
					$photo=$request->file('picture');
					$fileType=$photo->getClientOriginalExtension();
					$fileName=rand(1,1000).date('dmyhis').".".$fileType;
					$logo=$fileName;
					$photo->move('assets/img/logo', $fileName );
					 $data1['picture'] = $logo;

            	}
            
            $system = System::create($data1);

        
        //return view('agrihub.dashboard');

      return redirect(route('home'));
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
    }
}
