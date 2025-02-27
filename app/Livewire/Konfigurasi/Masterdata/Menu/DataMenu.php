<?php

namespace App\Livewire\Konfigurasi\Masterdata\Menu;

use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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
    public array $checked_permission = ['read', 'create', 'update', 'delete'];

    public $search = '';

    #[On('konfigurasi.masterdata.menu.submit')]
    public function submit($flag = 'confirm')
    {
        $this->validate();
        if ($flag === 'confirm' && $this->flag === 'update') {
            $this->dispatch('swal-confirm', 1, 'konfigurasi.masterdata.menu.submit', ['text' => "Data Menu \"{$this->name}\" yang diupdate akan merubah permission juga dan tidak dapat dikembalikan!"]);
            return;
        }

        DB::transaction(function () {
            $this->checked_permission = !$this->option ? $this->checked_permission : [];

            $data = [
                'group' => $this->group,
                'name' => $this->name,
                'option' => $this->option ? '__YES__' : '__NO__',
                'permissions' => json_encode($this->checked_permission),
                'index_sort' => Menu::where('group', $this->group)->count(),
                'user_id' => Auth::id()
            ];


            $menu = Menu::find($this->id) ?? Menu::create($data);

            if (!$this->option && $this->flag === 'tambah') {
                foreach ($this->checked_permission as $p) {
                    $n_name = Str::lower("$p $this->group.$this->name");
                    $permission = Permission::create(['name' => $n_name]);
                    $role = Role::findByName('administrator');
                    $role->givePermissionTo($permission);
                }
            }

            if ($this->flag === 'update') {
                $existingPermissions = Permission::where('name', 'like', "%{$menu->group}.{$menu->name}%")->get();
                $newPermissions = collect($this->checked_permission)->map(fn($p) => Str::lower("$p {$this->group}.{$this->name}"));

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

                $menu->update(array_merge($data, ['user_id_update' => Auth::id()]));
            }

            $this->dispatch('success', "Menu Berhasil di " . ($this->flag === 'update' ? "Update" : "Tambah"));
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

        $permissions = Permission::where('name', 'like', "%{$menu->group}.{$menu->name}%")->get();
        $permissions->each(fn($p) => $p->delete());

        $menu->delete();
        $this->dispatch('success', "Menu \"{$menu->name}\" berhasil di delete.");
    }
    public function setFrom($id): void
    {
        if ($id === null) {
            $this->reset();
            return;
        };

        $menu = Menu::find($id);

        $this->flag = 'update';
        $this->id = $menu->id;
        $this->group = $menu->group;
        $this->name = $menu->name;
        $this->option = $menu->option === '__YES__' ? true : false;
        $this->checked_permission = json_decode($menu->permissions, true);
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
        $permissions = array('create', 'update', 'delete', 'print', 'export', 'import');
        return view('livewire.konfigurasi.masterdata.menu.data-menu', compact('dataDaftar', 'permissions'));
    }

    public function updated(): void
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function placeholder()
    {
        return <<<'HTML'
        <div>
            <span class="placeholder col-12 placeholder-lg"></span>
            <span class="placeholder col-12"></span>
            <span class="placeholder col-12 placeholder-sm"></span>
            <span class="placeholder col-12 placeholder-xs"></span>
        </div>
        HTML;
    }
}
