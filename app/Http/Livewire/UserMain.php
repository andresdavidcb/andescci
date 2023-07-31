<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserMain extends Component
{
    public User $user;
    public $showEditModal = false;
    public $showDeleteModal = false;
    public $is_admin = 0;
    public $is_empresa = 0;
    public $selected = [];
    public $password, $password_confirmation;

    public $rules = [
        'user.name' => 'unique:users,name|string|required',
        'user.email' => 'unique:users,email|email|required',
        'password' => 'required|confirmed',
        'password_confirmation' => 'required',
        'is_admin' => 'nullable',
        'is_empresa' => 'nullable',
    ];

    public function render()
    {
        return view('livewire.user-main', [
            'users' => User::all(),
        ]);
    }

    public function makeBlank()
    {
        return User::make();
    }

    public function create()
    {
        $this->user = $this->makeBlank();
        $this->showEditModal = true;
    }

    public function edit($id)
    {
        $data = User::find($id);
        $this->user = $data;
        $this->showEditModal = true;
    }

    public function save()
    {
        $this->validate();

        if($this->password!=null)
        {
            $this->user->password = Hash::make($this->password);
        }

        if(Auth::user()->is_admin){
            $this->user->is_admin = $this->is_admin;
            $this->user->is_empresa = $this->is_empresa;
        } else {
            $this->user->is_admin = 0;
            $this->user->is_empresa = 1;
        }
        
        $this->user->save();
        $this->showEditModal = false;
    }
    
    
    public function deleteSelected()
    {
        $users = User::whereKey($this->selected);

        $users->delete();

        $this->showDeleteModal = false;
    }
}
