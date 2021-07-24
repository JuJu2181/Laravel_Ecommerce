<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SubVendor;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class SubVendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role == 'user' || Auth::user()->vendor_status == 'not_verified'){
            abort(403);
        }
        if(Auth::user()->role == 'vendor' && Auth::user()->vendor_status == 'verified'){
            $subvendors = SubVendor::latest('id')->where('vendor_id','=',Auth::id())->paginate(6);
        }else{
            $subvendors = SubVendor::latest('id')->paginate(6);
        }
        return view('admin.subvendor.index',compact('subvendors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->role != 'vendor'){
            abort(403);
        }
        return view('admin.subvendor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->role == 'user' || Auth::user()->vendor_status == 'not_verified'){
            abort(403);
        }
        // return $request;
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required',
            'responsibility'=>'required',
        ],
        // customizing error messages
        [
            'responsibility.required'=>'Please select atleast one responsibility'
        ]    
    );
        // return $request;
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role'=>'subvendor',
            'password' => Hash::make($request->password),
            'vendor_status'=>'verified',
        ]);
        $subvendor = new SubVendor();
        $subvendor->name = $request->name;
        $subvendor->email = $request->email;
        $subvendor->vendor_id = $request->vendor_id;
        $subvendor->responsibility = json_encode($request->responsibility);
        if($subvendor->save()){
            return redirect()->route('admin.subvendors.index')->with('success',$subvendor->name.'added successfully');
        }else{
            return redirect()->back()->with('error','Error in creating sub vendor');
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
        $subvendor = SubVendor::find($id);
        if(Auth::id() != $subvendor->vendor_id ){
            abort(403);
        }
        return view('admin.subvendor.edit',compact('subvendor'));
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
        $subvendor = SubVendor::find($id);
        $user = User::where('email','=',$subvendor->email)->first();
        if(Auth::id() != $subvendor->vendor_id ){
            abort(403);
        }
        if($subvendor->email == $request->email){
            $request->validate([
                'name' => 'required|string|max:255',
                'password' => 'required',
                'responsibility'=>'required',
            ],
            // customizing error messages
            [
                'responsibility.required'=>'Please select atleast one responsibility'
            ]    
            );
            // return $request;
            $user->name = $request->name;
            $user->password= Hash::make($request->password);
            if($user->save()){
                $subvendor->name = $request->name;
                $subvendor->responsibility = json_encode($request->responsibility);
                if($subvendor->save()){
                    return redirect()->route('admin.subvendors.index')->with('success',$subvendor->name.' updated successfully');
                }else{
                    return redirect()->back()->with('error','Error when creating sub vendor');
                }
            }else{
                return redirect()->back()->with('error','Error when creating user');
            }
        }else{
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required',
            'responsibility'=>'required',
        ],
        // customizing error messages
        [
            'responsibility.required'=>'Please select atleast one responsibility'
        ]    
        );
        // return $request;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password= Hash::make($request->password);
        if($user->save()){
            $subvendor->name = $request->name;
            $subvendor->email = $request->email;
            $subvendor->responsibility = json_encode($request->responsibility);
            if($subvendor->save()){
                return redirect()->route('admin.subvendors.index')->with('success',$subvendor->name.' updated successfully');
            }else{
                return redirect()->back()->with('error','Error when creating sub vendor');
            }
        }else{
            return redirect()->back()->with('error','Error when creating user');
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
        $subvendor = SubVendor::find($id);
        if(Auth::id() != $subvendor->vendor_id ){
            abort(403);
        }
        $user = User::where('email','=',$subvendor->email)->first();
        $subvendor->delete();
        $user->delete();
    }

    // public function getChangeTaskView(){

    // }

    // public function updateSubVendorTasks($id){

    // }
}
