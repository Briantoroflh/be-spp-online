<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bill extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'bills';
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'uuid',
        'student_uuid',
        'detail_bill_uuid',
        'year',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_uuid', 'uuid');
    }

    public function detailBill()
    {
        return $this->belongsTo(DetailBill::class, 'detail_bill_uuid', 'uuid');
    }

    public function currentBills()
    {
        return $this->hasMany(CurrentBill::class, 'bill_uuid', 'uuid');
    }
}
