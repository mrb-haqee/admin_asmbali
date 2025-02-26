<?php

namespace App\Livewire\Konfigurasi\Masterdata\Menu;

use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DataMenu extends Component
{
    public $id, $option, $flag = 'tambah';

    #[Rule('required|string')]
    public $name;

    #[Rule('required|string')]
    public $group;

    #[Rule('required|array')]
    public array $checked_permission = ['view', 'create', 'read', 'update', 'delete'];

    public $search = '';

    public function submit()
    {
        $this->validate();
        DB::transaction(function () {

            $data = [
                'group' => $this->group,
                'name' => $this->name,
                'option' => $this->option ? '__YES__' : '__NO__',
                'permissions' => $this->option ? json_encode($this->checked_permission) : null,
                'index_sort' => Menu::where('group', $this->group)->count(),
                'user_id' => Auth::id()
            ];

            $menu = Menu::find($this->id) ?? Menu::create($data);

            if ($this->option && $this->flag === 'tambah') {
                foreach ($this->checked_permission as $p) {
                    $permission = Permission::create(['name' => "$p $this->group.$this->name"]);
                    $role = Role::findByName('administrator');
                    $role->givePermissionTo($permission);
                }
            }

            if ($this->flag === 'update') {
                $existingPermissions = Permission::where('name', 'like', "%$this->group.$this->name%")->get();
                if ($existingPermissions->isEmpty()) {
                    if ($this->option) {
                        foreach ($this->checked_permission as $p) {
                            $permission = Permission::create(['name' => "$p $this->group.$this->name"]);
                            $role = Role::findByName('administrator');
                            $role->givePermissionTo($permission);
                        }
                    }
                } else {
                    foreach ($existingPermissions as $permission) {
                        if (in_array(explode(' ', $permission->name)[0], $this->checked_permission)) {
                            $newName = str_replace($this->name, $this->name, $permission->name);
                            $permission->name = $newName;
                            $permission->save();
                        } else {
                            $permission->delete();
                        }
                    }
                    if ($this->option) {
                        foreach ($this->checked_permission as $p) {
                            if (!$existingPermissions->contains('name', "$p $this->group.$this->name")) {
                                $permission = Permission::create(['name' => "$p $this->group.$this->name"]);
                                $role = Role::findByName('administrator');
                                $role->givePermissionTo($permission);
                            }
                        }
                    }
                }
                foreach ($data as $k => $v) {
                    if ($k === 'user_id') continue;
                    $menu->$k = $v;
                }
                $menu->user_id_update = Auth::id();
                $menu->save();
            }

            $this->dispatch('success', "Menu Berhasil di " . $this->flag === 'update' ? "Tambah" :  "Update");
            $this->reset();
        });
    }

    #[On('konfigurasi.masterdata.menu.delete')]
    public function delete($id, $flag)
    {
        $menu = Menu::find($id);
        if (!$menu) {
            $this->dispatch('error', 'Menu tidak ditemukan.');
            return;
        }

        if ($flag === 'confirm') {
            $this->dispatch('swal-confirm', $id, 'konfigurasi.masterdata.menu.delete', ['text' => "Data Menu \"{$menu->name}\" yang dihapus tidak dapat dikembalikan!"]);
            return;
        }

        $menu->delete();
        $this->dispatch('success', "Menu \"{$menu->name}\" berhasil di delete.");
    }
    public function setFrom($id): void
    {
        if (is_null($id)) {
            $this->reset();
            return;
        };

        $menu = Menu::find($id);

        $this->flag = 'update';
        $this->id = $menu->id;
        $this->group = $menu->group;
        $this->name = $menu->name;
        $this->option = $menu->option === '__YES__' ? true : false;
        $this->checked_permission = json_decode($menu->roles, true);
    }

    public function toggleRoles($value)
    {
        if (in_array($value, $this->checked_permission)) {
            $this->checked_permission = array_diff($this->checked_permission, [$value]);
        } else {
            $this->checked_permission[] = $value;
        }
    }

    #[On('success', 'swal')]
    public function render()
    {
        $dataDaftar = Menu::query();

        if (!empty($this->search)) {
            $dataDaftar->where('name', 'like', "%{$this->search}%")
                ->orWhere('group', 'like', "%{$this->search}%");
        } else {
            if (!empty($this->range) && str_contains($this->range, ' - ')) {
                [$startDate, $endDate] = explode(' - ', $this->range);
                // $query->whereBetween('created_at', [$startDate, $endDate]);
            }
        }

        $dataDaftar = $dataDaftar->orderBy('group')->orderBy('index_sort')->get();
        $permissions = array('view', 'create', 'read', 'update', 'delete', 'print', 'export', 'import');
        return view('livewire.konfigurasi.masterdata.menu.data-menu', compact('dataDaftar', 'permissions'));
    }

    public function updated(): void
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
