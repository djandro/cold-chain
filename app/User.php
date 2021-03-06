<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'approved_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function boot(){
        parent::boot();
        self::creating(function($users) {
            $users->api_token = \Hash::make(\Carbon\Carbon::now()->toRfc2822String());
        });
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function getRoles(){
        $roles = DB::table('role_user')
        ->join('roles', 'roles.id', '=', 'role_user.role_id')
        ->select('roles.name')
        ->where('role_user.user_id' , '=', $this->id)
        ->distinct()->get();

        return $roles;
    }

    /**
     * @param string|array $roles
     */
    public function authorizeRoles($roles)
    {
        if (is_array($roles)) {
            return $this->hasAnyRole($roles) || abort(401, 'This action is unauthorized.');
        }
        return $this->hasRole($roles) || abort(401, 'This action is unauthorized.');
    }
    /**
     * Check multiple roles
     * @param array $roles
     */
    public function hasAnyRole($roles)
    {
        return null !== $this->roles()->whereIn("name", $roles)->first();
    }
    /**
     * Check one role
     * @param string $role
     */
    public function hasRole($role)
    {
        return null !== $this->roles()->where("name", $role)->first();
    }

    public function getId()
    {
        return $this->id;
    }
    public function records(){
        return $this->hasMany(Records::class);
    }

    public static function getAdmins(){
        $admins = User::where('roles.name' , '=', 'admin')
                        ->join('role_user', 'users.id', '=', 'role_user.user_id')
                        ->join('roles', 'roles.id', '=', 'role_user.role_id')
                        ->whereNotNull ('users.approved_at')
                        ->distinct()->get();

        return $admins;
    }
}