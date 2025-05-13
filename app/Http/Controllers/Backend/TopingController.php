<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\toping;
use Illuminate\Http\Request;

class TopingController extends Controller
{
    public function viewToping(){
        return view('Backend.toping.toping-main', ['title' => 'Toping']);
    }

    public function editToping($id){
        $topings = toping::findOrFail($id);
        return view('Backend.toping.toping-main-edit', ['title' => 'Toping'], compact('topings'));
    }

    public function GetSubSubCategory($id_product){
        $subsubcat = toping::where('id_product', $id_product)->orderBy('name_toping', 'ASC')->get();
        // return json_encode($subsubcat);
        return response()->json($subsubcat);
    }
}
