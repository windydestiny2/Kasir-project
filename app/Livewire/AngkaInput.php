<?php

namespace App\Livewire;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Url;
use Livewire\Component;

class AngkaInput extends Component
{   
    #[Url]
    public $angka = '';
    public function render()
    {
        return view('livewire.angka-input');
    }
}
