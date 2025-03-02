<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountSub extends Model
{
    protected $fillable = [
        'kode',
        'name',
        'account_id',
        'keterangan',
        'user_id',
        'user_id_update',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
}
