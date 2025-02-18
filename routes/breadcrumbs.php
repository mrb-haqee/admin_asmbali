<?php

use App\Models\Menu;
use App\Models\User;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use Spatie\Permission\Models\Role;

$breadcrumbs = [
    'home' => ['Home', 'dashboard'],
    'dashboard' => ['Dashboard', 'dashboard', 'home'],
    'user-management.index' => ['User Management', 'user-management.users.index', 'dashboard'],
    'user-management.users.index' => ['Users', 'user-management.users.index', 'user-management.index'],
    'user-management.users.show' => ['User', 'user-management.users.show', 'user-management.users.index', User::class],
    'user-management.roles.index' => ['Roles', 'user-management.roles.index', 'user-management.index'],
    'user-management.roles.show' => ['Role', 'user-management.roles.show', 'user-management.roles.index', Role::class],
    'user-management.permissions.index' => ['Permissions', 'user-management.permissions.index', 'user-management.index'],
];

foreach ($breadcrumbs as $name => $breadcrumb) {
    Breadcrumbs::for($name, function (BreadcrumbTrail $trail, $model = null) use ($breadcrumb) {
        if (isset($breadcrumb[2])) {
            $trail->parent($breadcrumb[2]);
        }
        $label = $breadcrumb[0];
        $route = route($breadcrumb[1], $model);
        if ($model) {
            $label = ucwords($model->name);
        }
        $trail->push($label, $route);
    });
}
