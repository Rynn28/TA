<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UserDosen extends Model
{
    protected $table = 'users_dosen';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'nama',
        'nip',
        'nidn',
        'prodi',
        'foto',
        'role',
        'password'
    ];

    protected $hidden = [
        'password',
    ];

    public $timestamps = true;

    /**
     * Boot the model.
     */
    protected static function boot(): void
    {
        parent::boot();

        // Generate UUID untuk new records
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid()->toString();
            }
        });
    }
}