<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class apiCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $allCategories = DB::table("categories")
                        ->select("*")
                        ->get();

        return response()->json(['data'=>$allCategories],200);                  
    
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
        $allCategories = DB::table("categories")
                        ->select("*")
                        ->where("id",$id)
                        ->get();

        return response()->json(['data'=>$allCategories],200);  
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

    public function filterByCategoryProduct(Request $request){

        $data = array();
        $subcategory_id  = $request->subcategory_id;
        $user_id  = $request->user_id;

        if($user_id == null || $user_id == ""){

                    $products = DB::table("products")
                    ->join("categories","categories.id","products.category_id") 
                    ->join("subcategories","products.subcategory_id","subcategories.id")
                    ->join("brands","products.brand_id","brands.id")
                    ->join("products_colors","products.id","products_colors.product_id")
                    ->join("product_images","products.id","product_images.p_id")
                    ->where("subcategories.id",$subcategory_id)
                    ->select("*")
                    ->get();

            foreach ($products as $key => $value) {
                $data[$key]["products"] = $value;
                $data[$key]['favourite'] = false;
            }

        }
        else{
 
            $products = DB::table("products")
                    ->join("categories","categories.id","products.category_id") 
                    ->join("subcategories","products.subcategory_id","subcategories.id")
                    ->join("brands","products.brand_id","brands.id")
                    ->join("products_colors","products.id","products_colors.product_id")
                    ->join("product_images","products.id","product_images.p_id")
                    ->where("subcategories.id",$subcategory_id)
                    ->select("*")
                    ->get();

            foreach ($products as $key => $value) {
                $data[$key]["products"] = $value;
                $data[$key]['favourite'] = $this->isFavourite($user_id,$value->p_id);
            }

        }

      
        
                

         return response()->json(['data'=>$data]); 


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

    public function getSubcategories(Request $request){

        $data = array();
        $category_id = $data["category_id"] = $request->category_id;

        $subcategories = DB::table("subcategories")
                         ->select("id as sub_id", "category_id","subcategory_name")
                         ->where("category_id",$category_id)
                         ->get();

        return response()->json(['subcategories' => $subcategories],200);                 

    }

}
