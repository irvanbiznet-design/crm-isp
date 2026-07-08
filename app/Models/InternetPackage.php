<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternetPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'download_speed',
        'upload_speed',
        'burst',
        'limit',
        'price',
        'fup',
        'active_days',
        'description',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function customers()
    {
        return $this->hasMany(Customer::class, 'package_id');
    }
}
