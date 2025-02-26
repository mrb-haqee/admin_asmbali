<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    /** @use HasFactory<\Database\Factories\Menu2Factory> */
    use HasFactory;

    protected $fillable = [
        'group',
        'name',
        'option',
        'index_sort',
        'permissions',
    ];


    public function menuSubs()
    {
        return $this->hasMany(MenuSub::class, 'menu_id');
    }
}
