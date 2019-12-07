<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'old_password',
        'description',
        'image',
        'role_id',
        'social',
        'facebook',
        'twitter',
        'youtube',
        'instagram',
        'linkedin',
        'xing',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'old_password'
    ];

    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
