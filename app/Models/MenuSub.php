<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuSub extends Model
{
    /** @use HasFactory<\Database\Factories\MenuSubFactory> */
    use HasFactory;

    protected $fillable = [
        'menu_id',
        'name',
        'index_sort',
        'permissions',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }
}
