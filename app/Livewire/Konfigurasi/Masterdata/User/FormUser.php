<?php

namespace App\Livewire\Konfigurasi\Masterdata\User;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Role;

class FormUser extends Component
{
    use WithFileUploads;

    public $user_login_id;
    public $id;

    #[Rule('required|string', as: 'Name')]
    public $name;
    public $email;

    #[Rule('required|string')]
    public $role;

    #[Rule('nullable|sometimes|image|max:1024')]
    public $avatar;
    public $saved_avatar;
    public $flag = 'tambah';

    public function rules()
    {
        return [
            'email' => [
                'required',
                'string',
                'regex:/^@[\w]+$/', // Username harus diawali @ dan hanya boleh berisi huruf, angka, dan _
                $this->flag === 'tambah'
                    ? 'unique:users,email'
                    : "unique:users,email,{$this->id},id",
            ],
        ];
    }
    public function messages()
    {
        return [
            'email.regex' => 'Username harus diawali dengan @.',
        ];
    }


    public function submit(): void
    {
        $this->validate();
        DB::transaction(function () {
            $data = [
                'name' => $this->name,
            ];

            $data['profile_photo_path'] = $this->avatar ? $this->avatar->store('avatars', 'public') : null;

            if ($this->flag === 'tambah') {
                $data['password'] = Hash::make($this->email);
                $data['email_verified_at'] = now();
            }

            $data['email'] = $this->email;
            $user = User::find($this->id) ?? User::create($data);

            if ($this->flag === 'update') {
                foreach ($data as $k => $v) {
                    $user->$k = $v;
                }

                $user->save();
                $user->syncRoles($this->role);

                $this->dispatch('success', 'User berhasil diupdate.');
            } else {
                $user->assignRole($this->role);
                $this->dispatch('success', 'User berhasil dibuat.');
            }
        });

        $this->reset();
        $this->dispatch('refresh')->to(DaftarUser::class);
    }

    #[On('setForm')]
    public function setForm($id)
    {
        if (!$user = User::find($id)) {
            $this->reset();
            return;
        };

        $this->flag = 'update';
        $this->id = $user->id;
        $this->saved_avatar = $user->profile_photo_url;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->roles?->first()->name ?? null;
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

    public function updated(): void
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
