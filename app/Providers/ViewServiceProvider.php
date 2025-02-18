<?php

namespace App\Providers;

use App\Models\Menu;
use App\Models\Menu2;
use App\Models\MenuSub;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('layout.partials.sidebar-layout.sidebar._menu', function ($view) {

            $menus = Menu::with(['menuSubs' => function ($menuSubs) {
                $menuSubs->orderBy('index_sort');
            }])->orderBy('index_sort')
                ->get()
                ->groupBy('group')
                ->toArray();

            // dd($menus);

            // $menus = Menu::all()
            //     ->sortBy(function ($data) {
            //         return $data->perent_index_sort . '-' . $data->child_index_sort;
            //     })
            //     ->groupBy('group') // Grup berdasarkan 'group'
            //     ->map(function ($items) {
            //         return $items->groupBy('perent'); // Grup ulang berdasarkan 'perent'
            //     })
            //     ->toArray();

            // dd($menus);

            $view->with('menus', $menus);
        });
    }
}
