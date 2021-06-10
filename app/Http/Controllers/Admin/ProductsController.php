<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Http\Requests\ProductsFormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
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
        if(Auth::user()->role == "user"){
            abort(403);
        }elseif (Auth::user()->role == "vendor") {
            $products = Product::latest('id')->where('user_id','=',Auth::id())->paginate(6);
            return view('admin.products.index',compact('products'));
        }else{
            $products = Product::latest('id')->paginate(6);
            return view('admin.products.index',['products'=>$products]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->role == "user"){
            abort(403);
        }
        // $categories = Category::all();
        $categories = Category::with('children')->where('parent_id',0)->get();
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
        if(Auth::user()->role == "user"){
            abort(403);
        }
        //* using authorize helper function to check user authorization
        //? we use this method when we don't have the product model
        //! validation rules
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
        // return $request;
        $request->validated();
        $product = new Product;
        $product->name = $request->input('name');
        $product->user_id = Auth::id();
        $product->slug = $request->input('slug');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->category_id = $request->input('category_id');
        // for validating image 
        if($request->hasFile('image_upload')){
            // to get original name 
            // $name = time().'_'.$request->file('image_upload')->getClientOriginalName();
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
            image_crop($name);
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
        $this->authorize('update',$product);
        $categories = Category::with('children')->where('parent_id',0)->get();
        return view('admin.products.edit',["product"=>$product,"categories"=>$categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        // return $request;
        // ? using gates for authorization
        //*to check if updating product is allowed in controller using Gate::allows function
        // if(!Gate::allows('update-product',$product)){
        //     abort(403);
        // }
        //* alternatively we can use Gate::authorize which will also do the same thing and return 403 error if user is not authorized 
        // Gate::authorize('update-product',$product);

        // ? using authorize helper function which uses update function from policy for authorization
        $this->authorize('update',$product);
        // checking if the slug has changed or not if not then we don't need to check for error
        if($request->input('slug') == $product->slug){
            // return "true";
            $request->validate(
            [
                'name' => 'required|max:255|min:3',
                'description' => 'required|min:10',
                'price' => 'required|integer',
                'category_id'=>'required|integer|min:1',
                'image'=>'image|size:2048'
            ],
            // customizing error messages
            [
                'category_id.min'=>'Please select atleast one category',
                'price.integer'=>'Price should be an integer'
            ]
        );
        }else{
            // return "false";
        $request->validate(
            [
                'name' => 'required|max:255|min:3',
                'slug' => 'required|string|unique:products',
                'description' => 'required|min:10',
                'price' => 'required|integer',
                'category_id'=>'required|integer|min:1',
                'image'=>'image|size:2048',
            ],
            // customizing error messages
            [
                'category_id.min'=>'Please select atleast one category',
                'price.integer'=>'Price should be an integer'
            ]);

        }
        $product->name = $request->input('name');
        $product->slug = $request->input('slug');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->category_id = $request->input('category_id');
        // for validating image 
        if($request->hasFile('image_upload')){
            // to get original name 
            // $name = time().'_'.$request->file('image_upload')->getClientOriginalName();
            $name = $request->file('image_upload')->getClientOriginalName();
            $request->file('image_upload')->storeAs('public/images',$name);
            image_crop($name);
            $product->image = $name;
            // return $product->image;
        }
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

        $this->authorize('update',$product);
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
