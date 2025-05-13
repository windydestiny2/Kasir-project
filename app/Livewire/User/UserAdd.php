<?php

namespace App\Livewire\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class UserAdd extends Component
{
    use WithFileUploads;
    public $profil;

    public $name, $email, $password, $job, $phone, $telepon, $addres, $about;
    // public $dashboard, $admin, $product, $orderpes, $kategori, $riwayat;
    public $dashboard = 0;
    public $admin = 0;
    public $product = 0;
    public $kategori = 0;
    public $orderpes = 0;
    public $riwayat = 0;
    public $pengeluaran = 0;
    public $toping = 0;
    public $ukuran = 0;

    public function addUser(){
        $this->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|min:6|max:10',
            'job' => 'required',
            'profil' => 'nullable|image|mimes:jpg,png|max:1024'
        ]);

        $profil = $this->profil ? $this->profil->store('admin-image', 'public') : null;

        User::insert([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'job' => $this->job,
            'phone' => $this->phone,
            'addres' => $this->addres,
            'about' => $this->about,
            'profil' => $profil,

            'dashboard' => $this->dashboard,
            'admin' => $this->admin,
            'product' => $this->product,
            'kategori' => $this->kategori,
            'orderpes' => $this->orderpes,
            'riwayat' => $this->riwayat,
            'pengeluaran' => $this->pengeluaran,
            'toping' => $this->toping,
            'ukuran' => $this->ukuran,
        ]);

        $this->dispatch('success', message: 'Admin Berhasil Ditambahkan');
        $this->dispatch('addUser');

        $this->reset([
            'name', 'email', 'password', 'job', 'phone', 'addres', 'about', 'profil'
        ]);

        $this->dashboard = 0;
        $this->admin = 0;
        $this->product = 0;
        $this->kategori = 0;
        $this->orderpes = 0;
        $this->riwayat = 0;
        $this->pengeluaran = 0;
        $this->toping = 0;
        $this->ukuran = 0;


    }

    public function render()
    {
        return view('livewire.user.user-add');
    }
}
