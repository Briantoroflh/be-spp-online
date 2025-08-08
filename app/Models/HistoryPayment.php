<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class HistoryPayment extends Model
{
    use HasUuids;

    protected $primaryKey = 'id_history_payment';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['detail_payment_id', 'status', 'message'];

    public function detailPayment()
    {
        return $this->belongsTo(DetailPayment::class, 'detail_payment_id');
    }
}
