<?php

namespace App\Livewire\User;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class UserTable extends Component
{
    protected $listeners = ['addUser', 'deleteUser' => 'render'];

    public $search = '';
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function DeleteUser($id){
        $user = User::findOrFail($id);

        if ($user->profil) {
            Storage::disk('public')->delete($user->profil);
        }

        $user->delete();
        
        $this->dispatch('error', message: 'Berhasil Dihapus');
        $this->dispatch('deleteUser');
    }

    public function render()
    {
        // $users = User::whereIn('job', ['Admin, Kasir'])->limit(5)->get();
        $users = User::where('name', 'like', '%' . $this->search . '%')
        ->where(function ($query) {
            $query->where('job', 'Admin')
                ->orWhere('job', 'Kasir');
        })
        ->paginate(10);
        return view('livewire.user.user-table', compact('users'));
    }
}
