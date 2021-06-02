<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\CategoriesFormRequest;


class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::latest('id')->get();
        return view('admin.categories.index',['categories'=>$categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.categories.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoriesFormRequest $request)
    {
        // validation rules using the form request
        $request->validated();
        $category = new Category;
        $category->name = $request->input('name');
        $category->description = $request->input('description');
        // for validating image 
        if($request->hasFile('image_upload')){
            // to get original name 
            $name = $request->file('image_upload')->getClientOriginalName();
            // this also by default generates a random name
            // $product->image = $request->file('image_upload')->storage('public/images');
            // storing with its original name 
            $request->file('image_upload')->storeAs('public/images',$name);
            // * using the helper function directly
            // image_crop($name,550,750);
            $category->image = $name;
        }
        if($category->save()){
            return redirect()->route('admin.categories.index');
        }else{
            return redirect()->back();
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
