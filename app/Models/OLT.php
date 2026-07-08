<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OLT extends Model
{
    use HasFactory;

    protected $table = 'olts';

    protected $fillable = [
        'name',
        'ip_address',
        'port',
        'username',
        'password',
        'vendor',
        'model',
        'status',
        'cpu',
        'memory',
        'temperature',
        'last_sync',
    ];

    protected $casts = [
        'last_sync' => 'datetime',
    ];

    public function onus()
    {
        return $this->hasMany(ONU::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
}
