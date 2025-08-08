<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasUuids;

    protected $primaryKey = 'id_classes';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['classes_name', 'major', 'angkatan'];

    public function students()
    {
        return $this->hasMany(Student::class, 'classes_id');
    }
}
