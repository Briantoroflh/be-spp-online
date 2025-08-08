<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasUuids;

    protected $primaryKey = 'id_payment';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['student_id', 'date_payment', 'method_payment', 'total_amount'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function detailPayments()
    {
        return $this->hasMany(DetailPayment::class, 'payment_id');
    }
}
