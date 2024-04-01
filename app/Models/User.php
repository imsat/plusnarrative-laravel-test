<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'first_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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

    /**
     * The attributes that should be concat user first name and last name.
     *
     * @var array
     */
    protected $appends = [
        'full_name'
    ];

    /**
     * Get the user's avatar.
     */
    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->first_name . ' ' . $this->last_name
        );
    }

    /**
     * Many-To-Many Relationship Method for accessing the User->roles
     */

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Assign Roles to users
     */
    public function assignRole($role)
    {
        return  $this->roles()->syncWithoutDetaching(
            Role::whereSlug($role)->firstOrFail()
        );
    }

    /**
     * Assign multiple Roles to users
     */
    public function assignRoles($roles)
    {
        foreach ($roles as $role){
            $this->roles()->syncWithoutDetaching(
                Role::whereSlug($role)->firstOrFail()
            );
        }
        return $this;
    }

    /**
     * Check user has role
     *
     * @param  string  $role
     * @return string
     */
    public function hasRole($role)
    {
        if(is_string($role)){
            return $this->roles->contains('name', strtolower($role));
        }

        return !! $role->intersect($this->roles)->count();
    }
}
