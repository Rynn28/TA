<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    protected $fillable = [
        'nama',
        'nip',
        'nidn',
        'foto',
        'role'
    ];

    public $timestamps = true;
}