<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $abilities = [
            'view',
            'read',
            'create',
            'write',
            'update',
            'delete',
            'print',
        ];

        $permissions_by_role = [
            'administrator' => [
                // Group Page
                'menegament konfigurasi',
                'manajemen administrasi',
                'manajemen web_asm',
                'manajemen web_tpq',

                // Administrasi
                'administrasi.laporan',

                // Web-asm
                'web_asm.laporan',

                // Web-tpq
                'web_tpq.laporan',
            ],
            'admin' => [
                // Group Page
                'manajemen administrasi',
                'manajemen web_asm',
                'manajemen web_tpq',

                // Administrasi
                'administrasi.laporan',

                // Web-asm
                'web_asm.laporan',

                // Web-tpq
                'web_tpq.laporan',
            ],
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
