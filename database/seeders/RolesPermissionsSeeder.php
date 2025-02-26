<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = Menu::with(['menuSubs' => function ($menuSubs) {
            $menuSubs->orderBy('index_sort');
        }])->orderBy('index_sort')
            ->get()
            ->toArray();

        $paths = [];

        foreach ($menus as $menu) {
            $group = $menu['group'];
            $parentName = $menu['name'];

            if (empty($menu['menu_subs'])) {
                $paths[] = "{$group}/{$parentName}";
            } else {
                foreach ($menu['menu_subs'] as $subMenu) {
                    $childName = $subMenu['name'];
                    $paths[] = Str::lower("{$group}.{$parentName}.{$childName}");
                }
            }
        }
        $abilities = [
            'view',
            'read',
            'create',
            'write',
            'update',
            'delete',
        ];

        $permissions_by_role = [
            'administrator' => $paths
        ];

        foreach ($permissions_by_role['administrator'] as $permission) {
            foreach ($abilities as $ability) {
                Permission::create(['name' => $ability . ' ' . $permission]);
            }
        }

        foreach ($permissions_by_role as $role => $permissions) {
            $full_permissions_list = [];
            foreach ($abilities as $ability) {
                foreach ($permissions as $permission) {
                    $full_permissions_list[] = $ability . ' ' . $permission;
                }
            }
            Role::create(['name' => $role])->syncPermissions($full_permissions_list);
        }

        User::find(1)->assignRole('administrator');
    }
}
