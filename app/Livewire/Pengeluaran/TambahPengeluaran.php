<?php

namespace App\Livewire\Pengeluaran;

use App\Models\Pengeluaran;
use Livewire\Component;

class TambahPengeluaran extends Component
{
    public $tanggal, $keterangan, $jumlah;

    public function TambahPengeluaran(){
        $this->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required',
            'jumlah' => 'required'
        ]);

        // clear rupiah
        $jumlah = (int) str_replace('.', '', $this->jumlah);

        Pengeluaran::insert([
            'tanggal' => $this->tanggal,
            'keterangan' => $this->keterangan,
            'jumlah' => $jumlah,
        ]);

        $this->reset([
            'tanggal', 'keterangan', 'jumlah'
        ]);

        $this->dispatch('success', message: 'Pengeluaran berhasil ditambahkan');
        $this->dispatch('tambahPengeluaran');


    }

    public function render()
    {
        return view('livewire.pengeluaran.tambah-pengeluaran');
    }
}
