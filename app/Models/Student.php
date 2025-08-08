<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasUuids;

    protected $primaryKey = 'id_student';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['nisn', 'nis', 'name', 'classes_id', 'alamat', 'no_telp', 'users_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function class()
    {
        return $this->belongsTo(Classes::class, 'classes_id');
    }

    public function bills()
    {
        return $this->hasMany(Bill::class, 'student_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'student_id');
    }
}
