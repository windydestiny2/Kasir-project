<?php

namespace App\Livewire\Profil;

use App\Models\User;
// use Dotenv\Exception\ValidationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class EditProfil extends Component
{

    use WithFileUploads;
    

    public $name, $email, $phone, $job, $addres, $about, $profil;

    public $old_password, $password, $password_confirmation;

    public function mount(){
        $user = Auth::user();

        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->job = $user->job;
        $this->addres = $user->addres;
        $this->about = $user->about;

    }

    public function updateProfile(){
        $user = Auth::user();

        $this->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'nullable|string',
            'job' => 'nullable|string',
            'addres' => 'nullable|string',
            'about' => 'nullable|string',
            'profil' => 'nullable|image|max:2048',
        ]);


        // simpan gambar
        if ($this->profil) {
            // Hapus gambar lama
            if ($user->profil) {
                Storage::disk('public')->delete($user->profil);
            }

            $path = $this->profil->store('profile', 'public');
            $user->profil = $path;
        }
        
        $user->name = $this->name;
        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->job = $this->job;
        $user->addres = $this->addres;
        $user->about = $this->about;
        $user->save();

        $this->dispatch('success', message: 'Profil Berhasil diubah');
        $this->dispatch('updateProfil');
    }

    public function updatePassword(){
        $this->validate([
            'old_password' => 'required',
            'password' => 'required|max:10|min:8|confirmed',
            'password_confirmation' => 'required'
        ], [
            'old_password.required' => 'Password Lama Wajib diisi',
            'password.required' => 'Password Baru Wajib diisi',
            'password_confirmation.required' => 'Konfirmasi Password Wajib diisi',
            'password.min' => 'Password Minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi Password tidak cocok',
        ]);

        if (!Hash::check($this->old_password, Auth::user()->password)) {

            throw ValidationException::withMessages([
                'old_password' => 'Password Lama Tidak Sesuai'
            ]);

        }

        $user = User::find(1);
        $user->password = Hash::make($this->password);
        $user->save();
        
        $this->reset(['old_password', 'password', 'password_confirmation']);


        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('login');


    }

    public function render()
    {

        return view('livewire.profil.edit-profil');
    }
}
