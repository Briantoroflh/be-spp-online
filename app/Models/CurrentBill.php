<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CurrentBill extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'current_bills';
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'bill_uuid',
        'month',
        'start_date',
        'due_date',
        'status',
        'description',
    ];

    public function bill()
    {
        return $this->belongsTo(Bill::class, 'bill_uuid', 'uuid');
    }

    public function payment() {
        return $this->hasMany(Payment::class, 'current_bill_uuid');
    }
}
