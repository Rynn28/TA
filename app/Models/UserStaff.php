<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserStaff extends Model
{
    protected $table = 'users_staff';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'nama',
        'nip',
        'nidn',
        'bagian',
        'foto',
        'role',
        'password'
    ];

    protected $hidden = [
        'password',
    ];

    public $timestamps = true;
}
