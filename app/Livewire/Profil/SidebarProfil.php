<?php

namespace App\Livewire\Profil;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SidebarProfil extends Component
{
    protected $listeners = ['updateProfil' => 'render'];

    public function render()
    {
        $users = Auth::user();
        return view('livewire.profil.sidebar-profil', compact('users'));
    }
}
