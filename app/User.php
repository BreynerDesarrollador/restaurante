<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use NotificationChannels\WebPush\HasPushSubscriptions;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends \Eloquent implements Authenticatable
{
    use Notifiable, HasPushSubscriptions,EntrustUserTrait,AuthenticableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombres', 'apellidos', 'email','telefono', 'password', 'type','user','acceso', 'imagen',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

}