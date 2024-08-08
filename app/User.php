<?php

namespace App;

use App\Model\UserRole;
use App\Model\Admin\Setup\CEP_Region\SetupUserArea;
use App\Model\Admin\Setup\CEP_Region\SetupUser;
use App\Model\Admin\Employee\Employee;
use App\Model\Admin\Training\Trainer;
use App\Model\Participant\Participant;
use App\Model\Participant\ParticipantGroupDiscuss;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    // public function getRouteKeyName()
    // {
    //     return 'name';
    // }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'created_at', 'updated_at', 'deleted_at', 'updated_by', 'created_by',
    ];

    public function user_role()
    {
        return $this->hasMany(UserRole::class, 'user_id', 'id');
    }

    public function setup_user()
    {
        return $this->hasOne(SetupUser::class, 'user_id', 'id');
    }

    public function setup_user_area()
    {
        return $this->hasMany(SetupUserArea::class, 'user_id', 'id');
    }
}
