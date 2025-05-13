<?php

namespace App\Livewire\User;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class UserEdit extends Component
{   

    use WithFileUploads;
    public $profil, $old_image;

    public $user_id, $name, $email, $job, $phone, $telepon, $addres, $about;

    // public $dashboard, $admin, $product, $kategori, $orderpes, $riwayat;
    public $dashboard = 0;
    public $admin = 0;
    public $product = 0;
    public $kategori = 0;
    public $orderpes = 0;
    public $riwayat = 0;
    public $pengeluaran = 0;
    public $toping = 0;
    public $ukuran = 0;

    public function mount($users){
        $this->user_id = $users->id;
        $this->name = $users->name;
        $this->email = $users->email;
        $this->job = $users->job;
        $this->phone = $users->phone;
        $this->telepon = $users->telepon;
        $this->addres = $users->addres;
        $this->about = $users->about;
        $this->old_image = $users->profil;

        $this->dashboard = $users->dashboard;
        $this->admin = $users->admin;
        $this->product = $users->product;
        $this->kategori = $users->kategori;
        $this->orderpes = $users->orderpes;
        $this->riwayat = $users->riwayat;
        $this->pengeluaran = $users->pengeluaran;
        $this->toping = $users->toping;
        $this->ukuran = $users->ukuran;

        
    }

    public function editUser(){
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$this->user_id,
            'job' => 'required',
            'profil' => 'nullable|image|mimes:jpg,png|max:1024'
        ]);

        $user = User::findOrFail($this->user_id);

        if ($this->profil) {
            $save_img = $this->profil->store('admin-image', 'public');

            if ($user->profil) {
                Storage::disk('public')->delete($user->profil);
            }
            $user->profil = $save_img;
        }
        
        // dd([
        //     'dashboard' => $this->dashboard,
        //     'admin' => $this->admin,
        //     'product' => $this->product,
        //     'kategori' => $this->kategori,
        //     'orderpes' => $this->orderpes,
        //     'riwayat' => $this->riwayat,
        //     'pengeluaran' => $this->pengeluaran,
        // ]);

        $user->update([
            'name' => $this->name,
            'job' => $this->job,
            'about' => $this->about,
            'addres' => $this->addres,
            'phone' => $this->phone,
            'email' => $this->email,
            'profil' => $user->profil ?? $this->old_image,

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

        $notif = array(
            'message' => 'Berhasil Diupdate',
            'alert-type' => 'success'
        );

        return redirect()->route('view.user')->with($notif);
        
    }

    public function render()
    {
        $user = User::findOrFail($this->user_id);

        return view('livewire.user.user-edit', compact('user'));
    }
}
