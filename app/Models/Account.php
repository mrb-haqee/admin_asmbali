<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'kode',
        'name',
        'user_id',
        'user_id_update',
    ];

    public function accountSub()
    {
        return $this->hasMany(AccountSub::class, 'account_id');
    }
}
