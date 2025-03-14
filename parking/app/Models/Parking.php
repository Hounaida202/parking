<?php

namespace App\Models;
use app\Models\Places;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parking extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom', 'adresse'
    ];

    public function places()
{
    return $this->hasMany(Place::class);
}
}

