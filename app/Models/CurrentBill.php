<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrentBill extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'current_bills';
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'uuid',
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
}
