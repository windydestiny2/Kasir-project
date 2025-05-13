<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function viewUser(){
        return view('Backend.user.user-main', ['title' => 'ViewAdmin']);
    }

    public function editUser($id){
        $users = User::findOrFail($id);
        return view('Backend.user.user-edit', ['title' => 'EditDashboard'], compact('users'));
    }
}
