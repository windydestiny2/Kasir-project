<?php

namespace App\Livewire\Profil;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CardProfil extends Component
{   
    protected $listeners = ['updateProfil' => 'render'];
    
    public function render()
    {
        $users = Auth::user();

        return view('livewire.profil.card-profil', compact('users'));
    }
}
