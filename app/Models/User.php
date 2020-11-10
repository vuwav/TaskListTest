<?php

namespace App\Models;

use App\Traits\HasToken;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory, HasToken;

    public const ROLE_WORKER = 0;
    public const ROLE_MANAGER = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'login',
        'password',
        'password_confirmation',
        'name',
        'family',
        'surname',
        'role',
        'api_token',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function checkRole($role)
    {
        return $this->role === $role;
    }

    public function task($id)
    {
        return $this->tasks()->whereId($id);
    }

    public function tasks()
    {
        if ($this->checkRole(self::ROLE_WORKER)) {
            return $this->hasMany(Task::class, 'worker_id', 'id')->with('manager');
        }
        if ($this->checkRole(self::ROLE_MANAGER)) {
            return $this->hasMany(Task::class, 'manager_id', 'id')->with('user');
        }
    }

    public function workers()
    {
        if ($this->checkRole(self::ROLE_MANAGER)) {
            return $this->hasMany(self::class, 'manager_id', 'id');
        }
    }

    public function manager()
    {
        if ($this->checkRole(self::ROLE_WORKER)) {
            return $this->hasOne(self::class, 'id', 'manager_id');
        }
    }

}
