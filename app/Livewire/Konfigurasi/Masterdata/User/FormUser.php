<?php

namespace App\Livewire\Konfigurasi\Masterdata\User;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Role;

class FormUser extends Component
{
    use WithFileUploads;

    public $user_login_id;
    public $user_id;
    public $name;
    public $email;
    public $role;
    public $avatar;
    public $saved_avatar;
    public $flag = 'tambah';

    protected $rules = [
        'name' => 'required|string',
        'email' => 'required|email|unique:users,email',
        // 'role' => 'required|string',
        'avatar' => 'nullable|sometimes|image|max:1024',
    ];

    public function submit(): void
    {
        if ($this->flag === 'update') {
            $this->rules['email'] = 'required|email|unique:users,email,' . $this->user_id . ',id';
        }

        $this->validate();

        DB::transaction(function () {
            // Prepare the data for creating a new user
            $data = [
                'name' => $this->name,
            ];

            if ($this->avatar) {
                $data['profile_photo_path'] = $this->avatar->store('avatars', 'public');
            } else {
                $data['profile_photo_path'] = null;
            }

            if ($this->flag === 'tambah') {
                $data['password'] = Hash::make($this->email);
            }

            // Update or Create a new user record in the database
            $data['email'] = $this->email;
            $user = User::find($this->user_id) ?? User::create($data);

            if ($this->flag === 'update') {
                foreach ($data as $k => $v) {
                    $user->$k = $v;
                }
                $user->save();
            }

            if ($this->flag === 'update') {
                $user->syncRoles($this->role);

                // Emit a success event with a message
                $this->dispatch('success', __('User updated'));
            }
        });

        // Reset the form fields after successful submission
        $this->reset();
        $this->dispatch('proses-selesai');
    }

    public function delete($id)
    {
        // Prevent deletion of current user
        if ($id == Auth::id()) {
            $this->dispatch('error', 'User cannot be deleted');
            return;
        }

        // Delete the user record with the specified ID
        User::destroy($id);

        $this->dispatch('swal', __('Menu berhasil dihapus'), 'success');
        $this->dispatch('proses-selesai');
    }

    public function update($id): void
    {
        $this->flag = 'update';

        $user = User::find($id);

        $this->user_id = $user->id;
        $this->saved_avatar = $user->profile_photo_url;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->roles?->first()->name ?? '';

        $this->dispatch('select2');
    }

    public function resetFlag(): void
    {
        $this->flag === 'update' && $this->reset();
    }
    public function hydrate(): void
    {
        $this->resetErrorBag();
        $this->resetValidation();

        $this->user_login_id = Auth::user()->id;
    }
    public function render()
    {


        $roles = Role::all();

        $roles_description = [
            'administrator' => 'Best for business owners and company administrators',
            'developer' => 'Best for developers or people primarily using the API',
            'analyst' => 'Best for people who need full access to analytics data, but don\'t need to update business settings',
            'support' => 'Best for employees who regularly refund payments and respond to disputes',
            'trial' => 'Best for people who need to preview content data, but don\'t need to make any updates',
        ];

        foreach ($roles as $i => $role) {
            $roles[$i]->description = $roles_description[$role->name] ?? '';
        }

        return view('livewire.konfigurasi.masterdata.user.form-user', compact('roles'));
    }
}
