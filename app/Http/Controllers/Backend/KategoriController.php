<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function viewKategori(){
        return view('Backend.kategori.kategori-main', ['title' => 'ViewKategori']);
    }

    public function editKategori($id){
        $kategori = Kategori::findOrFail($id);
        return view('Backend.kategori.kategori-edit', ['title' => 'EditKategori'], compact('kategori'));
    }
}
