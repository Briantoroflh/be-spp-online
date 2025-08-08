<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class DetailPayment extends Model
{
    use HasUuids;

    protected $primaryKey = 'id_detail_payment';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['payment_id', 'bill_id', 'amount'];

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }

    public function bill()
    {
        return $this->belongsTo(Bill::class, 'bill_id');
    }

    public function histories()
    {
        return $this->hasMany(HistoryPayment::class, 'detail_payment_id');
    }
}
