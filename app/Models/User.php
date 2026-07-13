<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use App\Models\Role;
use App\Models\Permission;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function hasRole(string $roleSlug): bool
    {
        return $this->roles->contains(fn ($role) => $role->slug === $roleSlug);
    }

    public function hasPermission(string $permissionSlug): bool
    {
        return $this->permissions->contains(fn ($permission) => $permission->slug === $permissionSlug)
            || $this->roles->flatMap->permissions->contains(fn ($permission) => $permission->slug === $permissionSlug);
    }

    protected static function booted(): void
    {
        static::creating(function (User $user) {
            if (! $user->remember_token) {
                $user->remember_token = Str::random(10);
            }
        });
    }
}
