<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\cart;

class apiCartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
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
       $data = array();
        $data['user_id'] = $request->user_id;
        $data['product_id'] = $request->product_id;
        $data['cart_quantity'] = $request->cart_quantity;
        $data['isOrdered'] = $request->isOrdered;

        $cart = cart::where('product_id',$request->product_id)->where("user_id",$request->user_id)->where("isOrdered","no")->count();

        if($cart>0){
          $insertgetId = cart::where('product_id',$request->product_id)->where("user_id",$request->user_id)->where("isOrdered","no")->increment('cart_quantity',$request->cart_quantity);
        }
        else{
        $insertgetId = DB::table('carts')->insertGetId($data);
        }

        $getUserCart = DB::table("carts")
                        ->join("products","carts.product_id","products.id")
                        ->join("categories","categories.id","products.category_id") 
                    ->join("subcategories","products.subcategory_id","subcategories.id")
                    ->join("brands","products.brand_id","brands.id")
                    ->join("products_colors","products.id","products_colors.product_id")
                    ->join("product_images","products.id","product_images.p_id")
                        ->where("carts.user_id",$request->user_id)
                        ->where("carts.isOrdered","no")
                        ->select("*")
                       ->get();

        $data1 =array();

     foreach ($getUserCart as $key => $value) {
                $data1[$key]["products"] = $value;
                $data1[$key]['favourite'] = $this->isFavourite($request->user_id,$value->p_id);
                $data1[$key]['cart_quantity'] = $this->getCartQuantity($request->user_id,$value->p_id);
            }
                      

         // dd($getUserCart);              

         $total_price = 0;

         foreach($getUserCart as $getUserCarts){
            $total_price = $total_price + ($getUserCarts->selling_price*$getUserCarts->cart_quantity); 
         }  

        return response()->json(["data"=>$data1,"total_price"=>$total_price]);


        // return response()->json(["data"=>$data]);
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


    public function getUserCart(Request $request){
        $data = array();
        $userId = $request->user_id;

        $getUserCart = DB::table("carts")
                        ->join("products","carts.product_id","products.id")
                        ->join("categories","categories.id","products.category_id") 
                    ->join("subcategories","products.subcategory_id","subcategories.id")
                    ->join("brands","products.brand_id","brands.id")
                    ->join("products_colors","products.id","products_colors.product_id")
                    ->join("product_images","products.id","product_images.p_id")
                        ->where("carts.user_id",$request->user_id)
                        ->where("carts.isOrdered","no")
                        ->select("*","carts.id as cart_id")
                       ->get();


         foreach ($getUserCart as $key => $value) {
                $data[$key]["products"] = $value;
                $data[$key]['favourite'] = $this->isFavourite($userId,$value->p_id);
                $data[$key]['cart_quantity'] = $this->getCartQuantity($userId,$value->p_id);
            }
                      

         // dd($getUserCart);              

         $total_price = 0;

         foreach($getUserCart as $getUserCarts){
            $total_price = $total_price + ($getUserCarts->selling_price*$getUserCarts->cart_quantity); 
         }              


         // return response()->json(["user_cart"=>$getUserCart]);

         return response()->json(["data"=>$data,"total_price"=>$total_price]);              
    }
    
   private function getCartQuantity(string $userId,String $product_id){

        $cart_quantity = DB::table("carts")
                        ->select("cart_quantity")
                        ->where("user_id",$userId)
                        ->where("product_id",$product_id)
                        ->where("isOrdered","no")
                        ->get();

        $total = 0;
                        
        foreach($cart_quantity as $cart_quantity){
            $total = $total + $cart_quantity->cart_quantity;
        }

        return $total;                

    }
    
       public function updateCart(Request $request){
        $cart_id = $request->cart_id;
        $is_increment = $request->is_increment;
        $user_id = $request->user_id;

        $updated_cart_amount = 0;

        $cart_quantity = DB::table("carts")
                         ->select("cart_quantity")
                         ->where("id",$cart_id)
                         ->get();

        
        if($is_increment == "0"){
            //decrement
            foreach($cart_quantity as $cart_quantity){
              $updated_cart_amount = $cart_quantity->cart_quantity - 1;
         }}

         else if($is_increment == "1"){
            foreach($cart_quantity as $cart_quantity){
              $updated_cart_amount = $cart_quantity->cart_quantity + 1;
            }            
         }

         if($updated_cart_amount == "0"){
            DB::table('carts')->where('id', $request->cart_id)->delete();
         }


        DB::table("carts")
        ->where("id",$cart_id)
        ->update(['cart_quantity'=>$updated_cart_amount]);

        
        $getUserCart = DB::table("carts")
                        ->join("products","carts.product_id","products.id")
                        ->join("categories","categories.id","products.category_id") 
                    ->join("subcategories","products.subcategory_id","subcategories.id")
                    ->join("brands","products.brand_id","brands.id")
                    ->join("products_colors","products.id","products_colors.product_id")
                    ->join("product_images","products.id","product_images.p_id")
                        ->where("carts.user_id",$request->user_id)
                        ->where("carts.isOrdered","no")
                        ->select("*","carts.id as cart_id")
                       ->get();

        $data1 =array();

     foreach ($getUserCart as $key => $value) {
                $data1[$key]["products"] = $value;
                $data1[$key]['favourite'] = $this->isFavourite($request->user_id,$value->p_id);
                $data1[$key]['cart_quantity'] = $this->getCartQuantity($request->user_id,$value->p_id);
            }
                      

         // dd($getUserCart);              

         $total_price = 0;

         foreach($getUserCart as $getUserCarts){
            $total_price = $total_price + ($getUserCarts->selling_price*$getUserCarts->cart_quantity); 
         }  

        return response()->json(["data"=>$data1,"total_price"=>$total_price]);

        

    }


    
   private function isFavourite(string $userId,string $product_id){
        // dd($userId);
        // dd($product_id);
        $isfav = DB::table("favouriteproducts")
                ->select("*")
                ->where("product_id",$product_id)
                ->where("user_id",$userId)
                ->get();

        $count = 0;
        foreach ($isfav as $isfav ) {
            $count++;
        }

        if($count>0){
           return true; 
        }
        else if($count<=0){
            return false;
        }

        
    }
    
    public function mostpopularProducts(){

        $selectedproducts =DB::table('carts')
             ->join('products','carts.product_id','products.id')
             ->join("categories","categories.id","products.category_id") 
             ->join("subcategories","products.subcategory_id","subcategories.id")
             ->join("brands","products.brand_id","brands.id")
             ->leftjoin("products_colors","carts.product_id","products_colors.product_id")
             ->leftjoin("product_images","carts.product_id","product_images.p_id")
             ->leftjoin("favouriteproducts","products.id","favouriteproducts.product_id")
             ->select(
              '*',DB::raw('sum(carts.cart_quantity) as most_ordered'))
             ->where('carts.isOrdered', "yes")
             ->orderBy("most_ordered","desc")
             ->groupBy('products.id')
             ->get();

        return response()->json(['data'=>$selectedproducts]);     
    }

}
