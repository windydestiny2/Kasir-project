<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function viewProfil($id){
        $users = User::findOrFail($id);

        return view('Backend.profil.view-profil', compact('users'), ['title' => 'Profil']);
    }
}
