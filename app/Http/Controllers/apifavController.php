<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\favouriteproduct;
use DB;

class apifavController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
       // $product_id = $request->product_id;
       // $user_id = $request->user_id;
       // $is_favourite = $request->is_favourite;

       // favouriteproduct::Insert([
       //          'product_id' =>$request->product_id;
       //          'user_id' => $request->user_id;
       //          'is_favourite' => true
       //      ]);

       // return response()->json("Added Successful",201);

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
        
    }

    public function LikeUnlike(Request $request){
        $user_id = $request->user_id;
        $product_id = $request->product_id;

        $findProducts = DB::table("favouriteproducts")
        ->select("*")
        ->where("product_id",$product_id)
        ->where("user_id",$user_id)
        ->get();

        $count = 0 ;
        foreach($findProducts as $findProducts){
         $count++;
        }

        if($count == 0){
            
            favouriteproduct::Insert([
                'product_id' =>$request->product_id,
                'user_id' =>$request->user_id,
                'is_favourite' => true
            ]);

            $data = array();

            $data["favourite"] = "Favourite";
                
            return response()->json($data,200);
        }

        else{
            DB::table('favouriteproducts')->where("product_id",$product_id)->where("user_id",$user_id)->delete();
            $data["favourite"] = "unFavourite";
            return response()->json($data,200);
        }
    }
}
