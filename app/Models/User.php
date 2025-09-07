<?php

namespace App\Models;

use App\Enums\PermissionName;
use App\Enums\RoleName;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    protected $table    = 'users';
    protected $primaryKey = 'id';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'username',
        'password',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $hidden = [
        'id',
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at',
        'is_active'
    ];

    protected $appends = [
        'id_encrypt',
        'full_name',
    ];

    public static function boot()
    {
        parent::boot();
        self::deleting(function ($model) {
            $model->is_active = 0;
            $model->deleted_at = Carbon::now();
            $model->save();
        });
    }

    public function fullName(): Attribute
    {
        $fullName = $this->first_name.' '.$this->last_name;
        return Attribute::make(
            get: fn() => Str::squish($fullName)
        );
    }

    public function idEncrypt(): Attribute
    {
        return Attribute::make(
            get: fn() => base64_encode($this->id)
        );
    }

    public function scopeIsNotDeveloper($query)
    {
        $query->whereDoesntHave('roles', function(Builder $subquery){
            $subquery->where('name',RoleName::DEVELOPER->value);
        });
    }

    public function scopeIsActive($query)
    {
        $query->where('is_active',1);
    }

    //Usado para el control del Middledware
    public function hasRoles(array $roles)
    {
        foreach($roles as $role)
        {
            foreach($this->roles as $userRole)
            {
                if($userRole->name == $role){
                    return true;
                }
            }
        }
        return false;
    }

    //Usado para el control del Middledware
    public function hasPermissions(array $permissions)
    {
        // Check permissions via roles
        foreach ($this->roles as $userRole) {
            if ($this->checkPermissionsInCollection($userRole->permissions, $permissions)) {
                return true;
            }
        }
        // Check permissions directly assigned to user
        if ($this->checkPermissionsInCollection($this->permissions, $permissions)) {
            return true;
        }
        return false;
    }

    /**
     * Helper to check if any permission in the collection matches the given permissions or has FULL_ACCESS.
     */
    private function checkPermissionsInCollection($permissionCollection, array $permissions)
    {
        foreach ($permissionCollection as $userPermission) {
            if (
                in_array($userPermission->name, $permissions, true) ||
                $userPermission->name == PermissionName::FULL_ACCESS->value
            ) {
                return true;
            }
        }
        return false;
    }

    //Usado para el control de usuarios y su autenticación en el sistema
    public function checkRoles()
    {
        return !$this->roles->isEmpty();
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_role','user_id','role_id')->wherePivot('deleted_at', null);
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'user_permission','user_id','permission_id')->wherePivot('deleted_at', null);
    }

}
