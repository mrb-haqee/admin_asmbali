<?php

namespace App\Livewire\Konfigurasi\Masterdata\Menu\Detail;

use App\Models\Menu;
use App\Models\MenuSub;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class FormMenuSub extends Component
{

    public $id, $flag = 'tambah', $menu;

    #[Rule('required|string')]
    public $name;

    #[Rule('required|array')]
    public array $checked_permission = ['read', 'create', 'update', 'delete'];

    #[On('submit')]
    public function submit($flag = 'confirm')
    {

        $this->validate();
        if (!app()->runningUnitTests() && $flag === 'confirm' && $this->flag === 'update') {
            $this->dispatch('swal-confirm', [FormMenuSub::class, 'submit'], ['text' => "Data Menu Sub \"{$this->name}\" yang diupdate akan merubah permission juga dan tidak dapat dikembalikan!"]);
            return;
        }

        DB::transaction(function () {
            $data = [
                'name' => $this->name,
                'menu_id' => $this->menu->id,
                'permissions' => json_encode($this->checked_permission),
                'index_sort' => MenuSub::get()->count(),
                'user_id' => Auth::id()
            ];

            $menuSub = MenuSub::find($this->id) ?? MenuSub::create($data);

            if ($this->flag === 'tambah') {
                foreach ($this->checked_permission as $p) {
                    $n_name = Str::lower("$p {$this->menu->group}.{$this->menu->name}.$this->name");
                    $permission = Permission::create(['name' => $n_name]);
                    $role = Role::findByName('administrator');
                    $role->givePermissionTo($permission);
                }
            }

            if ($this->flag === 'update') {
                $existingPermissions = Permission::where('name', 'like', "%{$this->menu->group}.{$this->menu->group}.{$menuSub->name}%")->get();
                $newPermissions = collect($this->checked_permission)->map(fn($p) => Str::lower("$p {$this->menu->group}.{$this->menu->name}.$this->name"));

                $existingPermissions->each(function ($permission) use ($newPermissions) {
                    if ($newPermissions->contains($permission->name)) {
                        $newPermissions = $newPermissions->reject($permission->name);
                    } else {
                        $permission->delete();
                    }
                });

                $newPermissions->each(function ($permissionName) {
                    $permission = Permission::firstOrCreate(['name' => $permissionName]);
                    Role::findByName('administrator')->givePermissionTo($permission);
                });

                $menuSub->update(array_merge($data, ['user_id_update' => Auth::id()]));
            }


            $this->dispatch('success', "Menu Sub Berhasil di " . ($this->flag === 'update' ? "Update" : "Tambah"));
            $this->dispatch('refresh')->to(DaftarMenuSub::class);
            $this->resetExcept('menu');
        });
    }

    #[On('setForm')]
    public function setForm($id): void
    {
        if ($id === null) {
            $this->resetExcept('menu');
            return;
        };

        $menuSub = MenuSub::find($id);

        $this->flag = 'update';
        $this->id = $menuSub->id;
        $this->name = $menuSub->name;
        $this->checked_permission = json_decode($menuSub->permissions, true);
    }

    public function tgRoles($value)
    {
        if (in_array($value, $this->checked_permission)) {
            $this->checked_permission = array_diff($this->checked_permission, [$value]);
        } else {
            $this->checked_permission[] = $value;
        }
    }


    public function mount(Menu $menu)
    {
        $this->menu = $menu;
    }

    public function render()
    {
        $permissions = array('create', 'update', 'delete', 'print', 'export', 'import');
        return view('livewire.konfigurasi.masterdata.menu.detail.form-menu-sub', compact('permissions'));
    }

    public function updated(): void
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
