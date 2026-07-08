<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Router extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'ip_address',
        'port',
        'username',
        'password',
        'status',
        'cpu',
        'memory',
        'uptime',
        'last_sync',
    ];

    protected $casts = [
        'last_sync' => 'datetime',
    ];

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
}
