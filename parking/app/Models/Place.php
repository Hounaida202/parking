<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;
    protected $fillable = [
        'numeré', 'secteur','status','parkings_id'
    ];

    public function places()
{
    return $this->hasMany(Place::class); 
}
}
