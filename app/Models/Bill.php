<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasUuids;

    protected $primaryKey = 'id_bill';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['student_id', 'spp_id', 'month', 'year', 'amount', 'status'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function spp()
    {
        return $this->belongsTo(Spp::class, 'spp_id');
    }

    public function detailPayments()
    {
        return $this->hasMany(DetailPayment::class, 'bill_id');
    }
}
