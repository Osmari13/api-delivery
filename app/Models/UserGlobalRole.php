<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class UserGlobalRole extends Model
{
    use HasUuids; 
    protected $table = 'user_global_roles';

    protected $fillable = [
        'user',
        'role',
    ];
    protected $keyType = 'string';  // ← UUID es string
    public $incrementing = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'user', 'username');
    }
}
