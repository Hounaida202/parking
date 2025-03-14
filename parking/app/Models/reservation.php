<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'date', 'de', 'a', 'places_id', 'users_id' // Correction ici (users_id au lieu de user_id)
    ];

    public function place()
    {
        return $this->belongsTo(Place::class, 'places_id'); // Correction de la relation
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id'); // Ajout de la relation avec User
    }
}
