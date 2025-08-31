<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailBill extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'detail_bills';
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'uuid',
        'nominal_bill',
        'start_at',
        'end_at',
    ];

    public function bills()
    {
        return $this->hasMany(Bill::class, 'detail_bill_uuid', 'uuid');
    }
   
}
