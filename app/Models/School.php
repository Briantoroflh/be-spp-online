<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_uuid',
        'name',
        'photo',
        'region',
        'city',
        'address',
        'type_school',
        'isVerified'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_uuid');
    }

    public function student() {
        return $this->hasMany(Student::class);
    }
}
