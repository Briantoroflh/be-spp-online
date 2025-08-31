<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['current_bill_uuid', 'officer_uuid', 'nominal_payment', 'method_payment', 'payment_date', 'status'];

    public function currentBill()
    {
        return $this->belongsTo(CurrentBill::class, 'current_bill_uuid');
    }

    public function officer()
    {
        return $this->belongsTo(Officer::class, 'officer_uuid');
    }
}
