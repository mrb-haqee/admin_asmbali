<?php

namespace Tests\Unit\Konfigurasi\Masterdata;

use Tests\TestCase;
use Livewire\Livewire;
use App\Livewire\Konfigurasi\Masterdata\Menu\MenuIndex;
use App\Livewire\Konfigurasi\Masterdata\Menu\DataMenu;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MenuTest extends TestCase
{
    use RefreshDatabase;

    public function test_menu_index_component_renders_correctly(): void
    {

        $user = User::find(1); // Buat user dummy
        $this->actingAs($user); // Simulasikan user login

        Livewire::test(MenuIndex::class)
            ->assertStatus(200)
            ->assertSee('Menu');
    }

    public function test_data_menu_component_renders_correctly(): void
    {
        Livewire::test(DataMenu::class)
            ->assertStatus(200)
            ->assertSee('Search Menu');
    }

    public function test_can_add_menu_item(): void
    {
        Livewire::test(DataMenu::class)
            ->set('name', 'Test Menu')
            ->set('group', 'Test Group')
            ->call('submit')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('menus', [
            'name' => 'Test Menu',
            'group' => 'Test Group',
        ]);
    }

    public function test_can_update_menu_item(): void
    {
        $menu = Menu::create([
            'name' => 'Old Menu',
            'group' => 'Old Group',
            'index_sort' => 1,
            'permissions' => json_encode(['read']),
        ]);

        Livewire::test(DataMenu::class)
            ->set('testing', true)
            ->call('setFrom', $menu->id)
            ->set('name', 'Updated Menu')
            ->set('group', 'Updated Group')
            ->call('submit')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('menus', [
            'id' => $menu->id,
            'name' => 'Updated Menu',
            'group' => 'Updated Group',
        ]);
    }

    public function test_can_delete_menu_item(): void
    {
        $menu = Menu::create([
            'name' => 'Menu to Delete',
            'group' => 'Group to Delete',
            'permissions' => json_encode(['read']),
        ]);

        Livewire::test(DataMenu::class)
            ->call('delete', $menu->id, 'confirm')
            ->assertHasNoErrors();

        $this->assertDatabaseMissing('menus', [
            'id' => $menu->id,
        ]);
    }
}
