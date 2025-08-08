<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Spp extends Model
{
    use HasUuids;

    protected $primaryKey = 'id_spp';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['year', 'nominal', 'start_date', 'end_date'];

    public function bills()
    {
        return $this->hasMany(Bill::class, 'spp_id');
    }
}
