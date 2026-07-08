<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_number',
        'name',
        'nik',
        'phone',
        'email',
        'photo',
        'address',
        'latitude',
        'longitude',
        'area_id',
        'package_id',
        'status',
        'subscription_date',
        'due_date',
        'pppoe_username',
        'pppoe_password',
        'router_id',
        'olt_id',
        'onu_id',
        'olt_port',
        'vlan',
        'ip_address',
        'mac_address',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'subscription_date' => 'date',
        'due_date' => 'date',
    ];

    public function package()
    {
        return $this->belongsTo(InternetPackage::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function router()
    {
        return $this->belongsTo(Router::class);
    }

    public function olt()
    {
        return $this->belongsTo(OLT::class);
    }

    public function onu()
    {
        return $this->belongsTo(ONU::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
