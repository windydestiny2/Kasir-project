<?php

namespace App\Livewire\Pengeluaran;

use App\Models\Order;
use App\Models\Pengeluaran;
use Livewire\Component;

class CardPengeluaran extends Component
{   
    protected $listeners = ['cardPengeluaran'];
    
    public $orders;

    // public $pemasukan, $pengeluaran, $saldoAkhir;

    // public function updateCard(){
    //     $this->pemasukan = Order::sum('total');
    //     $this->pengeluaran = Order::sum('total');
    //     $this->saldoAkhir = $this->pemasukan - $this->pengeluaran;
    // }



    public function cardPengeluaran(){
        $this->render();
    }

    public function render()
    {
        $pemasukan = Order::sum('total');

        $pengeluaran = Pengeluaran::sum('jumlah');

        $saldoAkhir = $pemasukan - $pengeluaran;

        return view('livewire.pengeluaran.card-pengeluaran', compact('pemasukan', 'pengeluaran', 'saldoAkhir'));
    }
}
