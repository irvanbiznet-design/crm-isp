<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ONU extends Model
{
    use HasFactory;

    protected $table = 'onus';

    protected $fillable = [
        'olt_id',
        'serial_number',
        'port',
        'status',
        'rx_power',
        'tx_power',
        'los',
        'temperature',
        'voltage',
        'distance',
        'last_online',
    ];

    protected $casts = [
        'last_online' => 'datetime',
    ];

    public function olt()
    {
        return $this->belongsTo(OLT::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
}
