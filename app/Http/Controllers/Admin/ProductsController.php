<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Http\Requests\ProductsFormRequest;
use Intervention\Image\Facades\Image;
class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::latest('id')->get();
        return view('admin.products.index',['products'=>$products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        // return view("admin.products.create",["categories"=>$categories]);
        // alt using compact
        return view("admin.products.create",compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductsFormRequest $request)
    {   
        // validation rules
        // * manually created
        // $validated = $request->validate(
        //     [
        //         'name' => 'required|max:255|min:3',
        //         'description' => 'required|max:255|min:10',
        //         'price' => 'required|integer',
        //         'category_id'=>'required|integer|min:1'
        //     ],
        //     // customizing error messages
        //     [
        //         'category_id.min'=>'Please select atleast one category'
        //     ]
        // );

        // validation rules using the form request
        $request->validated();
        $product = new Product;
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->category_id = $request->input('category_id');
        // for validating image 
        if($request->hasFile('image_upload')){
            // to get original name 
            $name = $request->file('image_upload')->getClientOriginalName();
            // this also by default generates a random name
            // $product->image = $request->file('image_upload')->storage('public/images');
            // storing with its original name 
            $request->file('image_upload')->storeAs('public/images',$name);
            // for resizing image and saving in db
            // $image_resize = Image::make(storage_path('app/public/images/'.$name));
            // $image_resize->resize(550,750);
            // $image_resize->save(storage_path('app/public/images/thumbnail/'.$name));
            // * using the helper function directly
            image_crop($name,550,750);
            $product->image = $name;
        }
        if($product->save()){
            return redirect()->route('admin.products.index');
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
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit',["product"=>$product,"categories"=>$categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductsFormRequest $request, Product $product)
    {
        //
        $request->validated();
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->category_id = $request->input('category_id');
        if($product->save()){
            return redirect()->route('admin.products.index');
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
    // using route model binding
    public function destroy(Product $product)
    {
        //
        $product->delete();
        // for form delete
        // return redirect()->route('admin.products.index');
        // for ajax delete
        return response()->json([
            'success'=>'Product deleted success'
        ]);
    }

    public function delete(Product $product){
        return view('admin.products.delete',["product"=>$product]);
    }
}
