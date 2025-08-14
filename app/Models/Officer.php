<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Officer extends Model
{
    use HasUuids, HasApiTokens;

    protected $primaryKey = 'id_officer';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['username','password', 'email', 'role'];
}
