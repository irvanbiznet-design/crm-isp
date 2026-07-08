<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $fillable = [
        'city',
        'district',
        'village',
        'cluster',
        'fiber_route',
        'pole',
        'odc',
        'odp',
        'pop',
        'description',
    ];

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
}
