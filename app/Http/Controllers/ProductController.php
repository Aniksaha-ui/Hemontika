<?php

namespace App\Http\Controllers;
use Image;
use DB;
use Illuminate\Http\Request;

class ProductController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth:admin');
    }


    public function index(){

		    $product = DB::table('products')
		    				->join('categories','products.category_id','categories.id')
		    				->join('brands','products.brand_id','brands.id')
		    				->join('product_images','products.id','product_images.p_id')
		    				->select('products.*','categories.category_name','brands.brand_name','product_images.*')
		    				->get();




		    			
		                return view('admin.product.index',compact('product'));

    }

      public function create(){
 		$category = DB::table('categories')->get();
     	$brand = DB::table('brands')->get();
    	
    	return view('admin.product.create',compact('category','brand'));

    }


	  
	      public function GetSubcat($category_id){
	   	$cat = DB::table('subcategories')->where('category_id',$category_id)->get();
	   	return json_encode($cat);

	   }


    public function store(Request $request){
    
    $data = array();
    $data['product_name'] = $request->product_name;
    $data['product_code'] = $request->product_code;
    $data['product_quantity'] = $request->product_quantity;
    $data['discount_price'] = $request->discount_price;
    $data['category_id'] = $request->category_id;
    $data['subcategory_id'] = $request->subcategory_id;
    $data['brand_id'] = $request->brand_id;
    $data['product_size'] = $request->product_size;

    $data['selling_price'] = $request->selling_price;
    $data['product_details'] = $request->product_details;
    $data['video_link'] = $request->video_link;
    $data['isPackage'] = $request->package;
    $data['status'] = 1;

    $image_one = $request->image_one;
    $image_two = $request->image_two;
    $image_three = $request->image_three;

    $product = DB::table('products')->insertGetId($data);


    $color=array();
    $color['product_id']=$product;
    $color['color_one'] = $request->product_color1;
    $color['color_two'] = $request->product_color2;
    $color['color_three'] = $request->product_color3;

   	$product_color=DB::table('products_colors')->insertGetId($color);



   	$image=array();
    
    $image['p_id']=$product;
       
       if ($image_one && $image_two && $image_three) {
     $image_one_name = hexdec(uniqid()).'.'.$image_one->getClientOriginalExtension();
     Image::make($image_one)->resize(300,300)->save('image/product/'.$image_one_name);
     $image['image_one'] = 'image/product/'.$image_one_name;

     $image_two_name = hexdec(uniqid()).'.'.$image_two->getClientOriginalExtension();
     Image::make($image_two)->resize(300,300)->save('image/product/'.$image_two_name);
     $image['image_two'] = 'image/product/'.$image_two_name;


     $image_three_name = hexdec(uniqid()).'.'.$image_three->getClientOriginalExtension();
     Image::make($image_three)->resize(300,300)->save('image/product/'.$image_three_name);
     $image['image_three'] = 'image/product/'.$image_three_name;

   
    	$product_image=DB::table('product_images')->insertGetId($image);
  		
      $notification=array(
            'massage'=>'Product Added successfully',
            'alert-type'=>'success'
      );
           return Redirect()->back()->with($notification);


		}

	}



    public function ViewProduct($id){

    
  
		    $product = DB::table('products')
		    				->join('categories','products.category_id','categories.id')
		    				->join('brands','products.brand_id','brands.id')
		    				->join('product_images','products.id','product_images.p_id')
		    				->join('products_colors','products.id','products_colors.product_id')
		    				->where('products.id',$id)
		    				->select('products.*','categories.category_name','brands.brand_name','product_images.*','products_colors.*')
		    				->first();

                    return view('admin.product.show',compact('product'));
    				
    	 
  }




}
