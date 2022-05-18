<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\category;
use DB;

class CategoryController extends Controller
{
       public function __construct()
    {
        $this->middleware('auth:admin');
    }


    public function category(){

    		$category = category::all();

    		return view('admin.category.category',compact('category'));

    }

    public function storecategory(Request $request){
    	$validateData = $request->validate([
    		'category_name' => 'required|unique:categories|max:255'
    	]);

    	$data=array();
    	$data['category_name']=$request->category_name;
        $data['status']=$request->status;

    	DB::table('categories')->insert($data);


      $notification=array(
            'massage'=>'Category add successfully',
            'alert-type'=>'success'
      );

      return Redirect()->back()->with($notification);
    }



    public function Deletecategory($id){

    	DB::table('categories')->where('id',$id)->delete();


      $notification=array(
            'massage'=>'Category Deleted successfully',
            'alert-type'=>'success'
      );

      return Redirect()->back()->with($notification);

    }



    public function Editcategory($id){
    	$category=DB::table('categories')->where('id',$id)->first();
    	return view('admin.category.edit',compact('category'));
    }


    public function Updatecategory(Request $request,$id){

    	$validateData = $request->validate([
    		'category_name' => 'required|max:255'
    	]);

    	$data=array();
    	$data['category_name'] = $request->category_name;
        $data['status']=$request->status;
    	$update = DB::table('categories')->where('id',$id)->update($data);

    	if ($update) {

                  $notification=array(
            'massage'=>'Category Updated successfully',
            'alert-type'=>'success'
            );
    		return Redirect()->route('category')->with($notification);
	
    	}


    	else{

          $notification=array(
            'massage'=>'Nothing to Update',
            'alert-type'=>'success'
      );
    	
    		return Redirect()->route('category')->with($notification);	
    	}

    }




}
