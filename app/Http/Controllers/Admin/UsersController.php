<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\VendorVerificationMail;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role != 'admin'){
            abort(403);
        }
        $users = User::latest('id')->where('role','!=','admin')->paginate(6);
        return view('admin.users.index',compact('users'));
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
        if(Auth::user()->role != 'admin'){
            abort(403);
        }
        $user = User::find($id);
        return view('admin.users.edit',compact('user'));
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
        // return $request;
        if(Auth::user()->role != 'admin'){
            abort(403);
        }
        $user = User::find($id);
        $user->role = $request->role;
        if($user->save()){
            return redirect()->route('admin.users.index');
        }else{
            return redirect()->back();
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
        //
    }

    // function to get all pending vendors
    public function getVendorRequests(){
        if(Auth::user()->role != 'admin'){
            abort(403);
        }
        $pending_vendors = User::latest('id')->where('role','=','vendor')->where('vendor_status','=','not_verified')->paginate(6);
        return view('admin.users.vendor_requests',compact('pending_vendors'));
    }

    public function verifyVendor($id){
        $vendor = User::find($id);
        $vendor->vendor_status = 'verified';
        if($vendor->save()){
            $email = $vendor->email;
            Mail::to($email)->send(new VendorVerificationMail());
        return redirect()->route('admin.users.getVerifiedVendors')->with('success','Vendor Verified');
        }else{
            return redirect()->back()->with('error','Error in verifying vendor');
        }

    }

    // function to get all the verified vendors 
    public function getVerifiedVendors(){
        if(Auth::user()->role != 'admin'){
            abort(403);
        }
        $verified_vendors = User::latest('id')->where('role','=','vendor')->where('vendor_status','=','verified')->paginate(6);
        return view('admin.users.verified_vendors',compact('verified_vendors'));
    }
}
