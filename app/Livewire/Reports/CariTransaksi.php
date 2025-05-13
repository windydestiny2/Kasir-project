<?php

namespace App\Livewire\Reports;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class CariTransaksi extends Component
{
    public $search = '';
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $orders = Order::with('user')
        ->whereDate('created_at', 'like', '%' . $this->search . '%')
        ->paginate(10);
        return view('livewire.reports.cari-transaksi', compact('orders'));
    }
}
