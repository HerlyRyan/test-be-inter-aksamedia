<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'image', 'name', 'phone', 'division_id', 'position'
    ];

    public function division()
    {
        return $this->belongsTo(Divisions::class, 'division_id');
    }
}
