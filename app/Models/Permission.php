<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\EntrustPermission;

/**
 * Class Permission
 */
class Permission extends EntrustPermission
{
    protected $table = 'permissions';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'display_name',
        'description'
    ];

    protected $guarded = [];


}