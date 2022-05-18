<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\order;
use App\checkout;
use App\products;
class apiOrderController extends Controller
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

        $findCartIds = DB::table("carts")
                       ->select("*")
                       ->where("user_id",$request->user_id)
                       ->get();

         // dd($findCartIds);              


      $today = date("dm");
      $year = date("y");
    $rand = strtoupper(substr(uniqid(sha1(time())),0,8));
     $uniqueOrderId = $today . $rand. $year;
                   

        foreach($findCartIds as $findCartIds){
            checkout::Insert([
                'order_user_id'=> $request->user_id,
                'generate_ordertitle'=> $uniqueOrderId,
                'order_cart_id'=> $findCartIds->id,
                "order_status" => "Pending"
            ]);

            DB::table('carts')
            ->where('id', $findCartIds->id)   
            ->update(['isordered' =>"yes"]);

           $product_total_quantity =  DB::table("products")
                                ->select("product_quantity")
                                ->where("id",$findCartIds->id)
                                ->get();

           // products::findorFail($findCartIds->product_id)->decrement('product_quantity',$findCartIds->cart_quantity);
        
        }    


        return response()->json($findCartIds);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
