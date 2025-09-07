<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use HasFactory, SoftDeletes;

    protected $table    = 'permissions';
    protected $primaryKey = 'id';

    protected $attributes = [
        'is_active' => 1,
    ];

    protected $fillable = [
        'name',
        'description',
    ];

    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at',
        'is_active',
    ];

    protected $appends = [
        'id_encrypt',
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

    public function idEncrypt(): Attribute
    {
        return Attribute::make(
            get: fn() => base64_encode($this->id)
        );
    }

    public function scopeIsActive($query)
    {
        $query->where('is_active', 1);
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class,'role_permission','permission_id','role_id')->where('is_active',1);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class,'user_permission','permission_id','user_id')->where('is_active',1);
    }
}
