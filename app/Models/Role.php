<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\EntrustRole;

/**
 * Class Role
 */
class Role extends EntrustRole
{
    protected $table = 'roles';

    public $timestamps = false;

    protected $fillable = [
        'descripcion'
    ];

    protected $guarded = [];

        
}