<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function viewProduct(){
        return view('Backend.Product.product-main', ['title' => 'Product']);
    }

    public function editProduct($id){
        $products = Product::findOrFail($id);
        return view('Backend.Product.product-main-edit', ['title' => 'Edit Product'], compact('products'));
    }

}
