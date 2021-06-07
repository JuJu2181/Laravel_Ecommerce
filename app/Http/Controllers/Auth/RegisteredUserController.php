<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        // return $request;
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'image' => 'image',
            'role' => 'required|string',
        ]);
        
        if($request->hasFile('image')){
            // to get original name 
            $name = $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public/images',$name);
            // * using the helper function directly
            // image_crop($name,80,80);
        }else{
            $name = '';
        }
        // return $request->role;
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role'=>$request->role,
            'password' => Hash::make($request->password),
            'image'=>$name,
        ]);

        // return $user;

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
