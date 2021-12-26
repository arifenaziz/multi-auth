<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public static function createRole($name)
    {
        // if role has exist, then return the role
        $role = Role::where('name', $name)->first();
        if(!is_null($role)){
            return $role;
        }else{
            // else create a role
            $role = Role::create(['name' => $name,'guard_name' => 'admin']);
        }
        return $role;
    }

    public static function getpermissionGroups()
    {
        $permission_groups = DB::table('permissions')
            ->select('group_name as name')    
            ->groupBy('group_name')
            ->get();
        return $permission_groups;
    }

    public static function getpermissionsByGroupName($group_name)
    {
        $permissions = DB::table('permissions')
            ->select('name', 'id')
            ->where('group_name', $group_name)
            ->get();
        return $permissions;
    }

    public static function roleHasPermissions($role, $permissions)
    {
        $hasPermission = true;
        foreach ($permissions as $permission) {
            if (!$role->hasPermissionTo($permission->name)) {
                $hasPermission = false;
                return $hasPermission;
            }
        }
        return $hasPermission;
    }    


}
