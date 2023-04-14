<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\backend\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class BookcategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
  
        	
    public function BookCategoryList(Request $request)
    {
        $list = DB::table('products')->get();
        return view('backend.carts.product_cart',compact('list'));
    }


public function BookCategoryAdd()
{
$all = DB::table('bookcategories')->get();
return view('backend.bookcategory.create_bookcategory',compact('all'));
}

    

    public function BookCategoryInsert(Request $request)
    {
$data = array();
$data['name'] = $request->name;
$data['slug'] = $request->slug;    
$insert = DB::table('bookcategories')->insert($data);
       
if ($insert) 
{
   
                return Redirect()->route('bookcategory.index')->with('success','Book Category created successfully!');
                 
        }
else
        {
        $notification=array
        (
        'message'=>'error ',
        'alert-type'=>'error'
        );
        return Redirect()->route('bookcategory.index')->with($notification);
        }
           
}

      public function BookEditCategory ($id)
    {
        $edit=DB::table('bookcategories')
             ->where('id',$id)
             ->first();
        return view('backend.bookcategory.edit_bookcategory', compact('edit'));     
    }

        public function BookUpdateCategory(Request $request,$id)
    {
      
        DB::table('bookcategories')->where('id', $id)->first();        
        $data = array();
        $data['name'] = $request->name;
        $data['slug'] = $request->slug;
        $update = DB::table('bookcategories')->where('id', $id)->update($data);

        if ($update) 
    {
            
            return Redirect()->route('bookcategory.index')->with('success','Book Category Updated successfully!');                     
    }
        else
    {
        $notification=array
        (
        'message'=>'error ',
        'alert-type'=>'error'
        );
        return Redirect()->route('bookcategory.index')->with($notification);
    }
     
    }

public function BookDeleteCategory ($id)
    {
    
        $delete = DB::table('bookcategories')->where('id', $id)->delete();
        if ($delete)
                            {
                            $notification=array(
                            'message'=>'Successfully Book Category Deleted ',
                            'alert-type'=>'success'
                            );
                            return Redirect()->back()->with($notification);                      
                            }
             else
                  {
                  $notification=array(
                  'message'=>'error ',
                  'alert-type'=>'error'
                  );
                  return Redirect()->back()->with($notification);

                  }

      }
}
