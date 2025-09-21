<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Student extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_uuid',
        'school_uuid',
        'photo',
        'name',
        'nisn',
        'nipd',
        'age',
        'address',
        'classes',
        'major',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_uuid');
    }

    public function school() {
        $this->belongsTo(School::class, 'school_uuid');
    }

    public function bills()
    {
        return $this->hasMany(Bill::class, 'student_uuid');
    }
}
