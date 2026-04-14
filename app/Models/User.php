<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users_dosen';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'nama',
        'nip',
        'nidn',
        'foto',
        'role',
        'password'
    ];

    protected $hidden = [
        'password',
    ];

    public $timestamps = true;
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users_dosen';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'nama',
        'nip',
        'nidn',
        'foto',
        'role',
        'password'
    ];

    protected $hidden = [
        'password',
    ];

    public $timestamps = true;
}


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users_dosen';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'nama',
        'nip',
        'nidn',
        'foto',
        'role',
        'password'
    ];

    protected $hidden = [
        'password',
    ];

    public $timestamps = true;
}