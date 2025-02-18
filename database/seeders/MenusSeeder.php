<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuSub;
use Illuminate\Database\Seeder;

class MenusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            // ! KONFIGURASI
            [
                'group' => 'konfigurasi',
                'name' => 'Masterdata',
                'option' => '__YES__',
                'index_sort' => '1',
                'child' => [
                    [
                        'name' => 'Menu',
                        'index_sort' => '1',
                    ],
                    [
                        'name' => 'User',
                        'index_sort' => '2',
                    ],
                ]
            ],
            [
                'group' => 'konfigurasi',
                'name' => 'Aksesibilitas',
                'option' => '__YES__',
                'index_sort' => '2',
                'child' => [
                    [
                        'name' => 'Roles',
                        'index_sort' => '1',
                    ],
                    [
                        'name' => 'Permission',
                        'index_sort' => '2',
                    ],
                ]
            ],

            // ! ADMINISTRASI
            [
                'group' => 'administrasi',
                'name' => 'Laporan',
                'option' => '__NO__',
                'index_sort' => '1',
            ],

            // ! WEB ASM
            [
                'group' => 'web_asm',
                'name' => 'Content',
                'option' => '__NO__',
                'index_sort' => '1',
            ],

            // ! WEB TPQ
            [
                'group' => 'web_tpq',
                'name' => 'Content',
                'option' => '__NO__',
                'index_sort' => '1',
            ],
        ];

        foreach ($data as $row) {
            $childData = $row['child'] ?? null;
            unset($row['child']);

            $menu = Menu::create($row);

            if ($row['option'] === '__YES__' && $childData) {
                foreach ($childData as $item) {
                    MenuSub::create(array_merge($item, ['menu_id' => $menu->id]));
                }
            }
        }
    }
}
