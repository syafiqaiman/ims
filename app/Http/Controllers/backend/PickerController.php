<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Picker;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class PickerController extends Controller
{
    public function PickerTaskList()
    {
        $user = Auth::user();
        $pickers = Picker::where('user_id', $user->id)->get();
    
        foreach ($pickers as $picker) {
            $product = Product::find($picker->product_id);
            $picker->product_name = $product->name;
        }
    
        return view('backend.picker.picker_task', ['pickers' => $pickers]);
    }
}
