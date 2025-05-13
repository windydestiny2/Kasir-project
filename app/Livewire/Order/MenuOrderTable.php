<?php

namespace App\Livewire\Order;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class MenuOrderTable extends Component
{

    // protected $listeners = ['stokUpdate' => '$refresh'];
    
    
    

    

    public function render()
    {
        $products = Product::all();
        return view('livewire.order.menu-order-table', compact('products'));
    }

    

    
}
