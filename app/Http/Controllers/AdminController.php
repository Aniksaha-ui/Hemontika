<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
use Auth;
use App\User;
use DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){


    		return view('admin.home');
    }


    

    public  function Logout(){
    	        Auth::logout();

      $notification=array(
            'massage'=>'Admin Successfully logout',
            'alert-type'=>'success'
      );

      return redirect()->route('admin.login')->with($notification);
    }
}
