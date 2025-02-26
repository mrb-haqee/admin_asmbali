<?php

namespace App\Http\Middleware;

use App\Models\Menu;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class MenuAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // $user = Auth::user();

        // if (!$user) {
        //     return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        // }

        // $currentUrl = $request->path(); // Contoh: 'dashboard/settings'

        // $menus = Menu::with(['menuSubs' => function ($menuSubs) {
        //     $menuSubs->orderBy('index_sort');
        // }])->orderBy('index_sort')
        //     ->get()
        //     ->toArray();

        // $paths = [];

        // foreach ($menus as $menu) {
        //     $group = $menu['group'];
        //     $parentName = $menu['name'];

        //     if (empty($menu['menu_subs'])) {
        //         $paths[] = "{$group}/{$parentName}";
        //     } else {
        //         foreach ($menu['menu_subs'] as $subMenu) {
        //             $childName = $subMenu['name'];
        //             $paths[] = Str::lower("{$group}/{$parentName}/{$childName}");
        //         }
        //     }
        // }


        // dd($currentUrl);

        // $allowedMenus = $user->allowed_menus ?? [];

        // if (!in_array($currentUrl, $allowedMenus)) {
        //     return redirect('/login')->with('error', 'Tidak Memiliki Akses ke ini.');
        // }

        return $next($request);
    }
}
