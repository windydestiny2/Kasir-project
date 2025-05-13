<?php

namespace App\Livewire\Pengeluaran;

use App\Models\Pengeluaran;
use Livewire\Component;

class UpdatePengeluaran extends Component
{   

    public $id_pengeluaran;
    public $tanggal, $jumlah, $keterangan;

    public function mount($pengeluaran){
        $this->id_pengeluaran = $pengeluaran->id;
        $this->tanggal = $pengeluaran->tanggal;
        $this->keterangan = $pengeluaran->keterangan;
        $this->jumlah = number_format($pengeluaran->jumlah, 0, ',', '.');
    }

    public function EditPengeluaran(){
        $this->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required',
            'jumlah' => 'required'
        ]);

        $update = Pengeluaran::findOrFail($this->id_pengeluaran);

        $jumlah = (int) str_replace('.', '', $this->jumlah);

        $update->update([
            'tanggal' => $this->tanggal,
            'keterangan' => $this->keterangan,
            'jumlah' => $jumlah,
        ]);
        

        $notif = array(
            'message' => 'Pengeluaran berhasil diupdate',
            'alert-type' => 'success'
        );

        return redirect()->route('view.pengeluaran')->with($notif);

    }

    public function render()
    {
        return view('livewire.pengeluaran.update-pengeluaran');
    }
}
