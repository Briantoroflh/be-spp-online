<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailBill extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'detail_bills';
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nominal_bill',
        'tax_bill',
        'start_at',
        'end_at',
    ];

    public function bill()
    {
        return $this->hasMany(Bill::class, 'detail_bill_uuid', 'uuid');
    }
   
}
