<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Officer extends Model
{
    use HasFactory, HasUuids, HasApiTokens;

    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['username', 'password', 'email','code_otp'];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'officer_roles', 'officer_uuid', 'role_uuid');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'officer_uuid');
    }

    public function hasRole($roleName): bool
    {
        return $this->roles()->where('name', $roleName)->exists();
    }
}
