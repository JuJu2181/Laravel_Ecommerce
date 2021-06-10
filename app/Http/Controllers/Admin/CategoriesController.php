<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CategoriesFormRequest;
use Illuminate\Support\Facades\Gate;


class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // ? using gates for authorization
        //*to check if updating product is allowed in controller using Gate::allows function
        if(!Gate::allows('authorize-category')){
            abort(403);
        }
        $categories = Category::latest('id')->paginate(4);
        return view('admin.categories.index',['categories'=>$categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Gate::allows('authorize-category')){
            abort(403);
        }
        // $categories = Category::all();
        $categories = Category::with('children')->where('parent_id',0)->get();
        // return $categories;
        return view("admin.categories.create",compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoriesFormRequest $request)
    {
        if(!Gate::allows('authorize-category')){
            abort(403);
        }
        // return $request;
        // validation rules using the form request
        $request->validated();
        //* for auto generating slug based on name without form modification. Here slug is not submitted using form but instead it is generated in controller using the submitted name
        /**
         * $slug = strtolower(str_replace(' ','-',$request->input('name)));
         * $categories = Category::whereSlug($slug)->get();
         * if($categories->count() > 0){
         *  return redirect()->back()->withErrors(['Slug must be unique]);
         * }
         */
        //* for allowing users to modify slug we generate the slug using javascript and submit it with the form
        $category = new Category;
        $category->name = $request->input('name');
        $category->description = $request->input('description');
        // *parent category id and slug 
        $category->parent_id = $request->input('parent_id');
        $category->slug = $request->input('slug');
        // for validating image 
        if($request->hasFile('image_upload')){
            // to get original name 
            // $name = time().'_'.$request->file('image_upload')->getClientOriginalName();
            $name = $request->file('image_upload')->getClientOriginalName();
            // this also by default generates a random name
            // $product->image = $request->file('image_upload')->storage('public/images');
            // storing with its original name 
            $request->file('image_upload')->storeAs('public/images',$name);
            // * using the helper function directly
            // image_crop($name);
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
        if(!Gate::allows('authorize-category')){
            abort(403);
        }
        $categories = Category::with('children')->where('parent_id',0)->get();
        $category1 = Category::find($id);
        return view("admin.categories.edit",compact('categories','category1'));
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
        $category= Category::find($id);
        if(!Gate::allows('authorize-category')){
            abort(403);
        }
        if($request->input('slug') == $category->slug){
            // return "true";
            $request->validate(
            [
                'name' => 'required|max:255|min:3',
                'description' => 'required|max:255|min:10',
                'image'=>'image|size:2048'
            ],
        );
        }else{
            // return "false";
        $request->validate(
            [
                'name' => 'required|unique:categories|max:255|min:3',
                'slug' => 'required|string|unique:categories',
                'description' => 'required|max:255|min:10',
                'image'=>'image|size:2048',
            ],
        );
        }
        $category->name = $request->input('name');
        $category->description = $request->input('description');
        // *parent category id and slug 
        $category->parent_id = $request->input('parent_id');
        $category->slug = $request->input('slug');
        // for validating image 
        if($request->hasFile('image_upload')){
            // to get original name 
            // $name = time().'_'.$request->file('image_upload')->getClientOriginalName();
            $name = $request->file('image_upload')->getClientOriginalName();
            // this also by default generates a random name
            // $product->image = $request->file('image_upload')->storage('public/images');
            // storing with its original name 
            $request->file('image_upload')->storeAs('public/images',$name);
            // * using the helper function directly
            // image_crop($name);
            $category->image = $name;
        }
        if($category->save()){
            return redirect()->route('admin.categories.index');
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
        if(!Gate::allows('authorize-category')){
            abort(403);
        }
        $category = Category::find($id);
        $category->delete();
    }
}
