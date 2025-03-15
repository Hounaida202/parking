<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'de' => 'required',
            'a' => 'required',
            
        ]);
    
// -------verification de l intervale de reservation--------


        $existeDeja = Reservation::where('places_id', $request->places_id)
            ->where('date', $request->date)
            ->where(function ($query) use ($request) {
                $query->whereBetween('de', [$request->de, $request->a])
                      ->orWhereBetween('a', [$request->de, $request->a])
                      ->orWhere(function ($q) use ($request) {
                          $q->where('de', '<=', $request->de)
                            ->where('a', '>=', $request->a);
                      });
            })
            ->exists();
    
        if ($existeDeja) {
            return response()->json(['message' => 'Cette place est déjà réservée sur ce créneau'], 409);
        }
    
        $reservation = Reservation::create([
            'date' => $request->date,
            'de' => $request->de,
            'a' => $request->a,
            'places_id' => $request->places_id,
            'users_id' => Auth::id(),
        ]);
    
        return response()->json([
            'message' => 'Réservation créée avec succès',
            'reservation' => $reservation
        ], 201);
    }

    public function modifierReservation(Request $request, $id)
{
    // Vérifier si la réservation existe
    $reservation = Reservation::find($id);

    if (!$reservation) {
        return response()->json([
            'message' => 'Réservation non trouvée'
        ], 404);
    }

   
    // Mise à jour des champs
    $reservation->update([
        'date' => $request->date ?? $reservation->date,
        'de' => $request->de ?? $reservation->de,
        'a' => $request->a ?? $reservation->a,
        'places_id' => $request->places_id ?? $reservation->places_id,
    ]);

    return response()->json([
        'message' => 'Réservation mise à jour avec succès',
        'reservation' => $reservation
    ], 200);
}
        public function supprimerReservation($id)
        {
            // Récupérer la réservation
            $reservation = Reservation::find($id);

            // Vérifier si la réservation existe
            if (!$reservation) {
                return response()->json([
                    'message' => 'Réservation non trouvée'
                ], 404);
            }

          
            // Supprimer la réservation
            $reservation->delete();

            return response()->json([
                'message' => 'Réservation supprimée avec succès'
            ], 200);
        }

        public function mesReservations()
        {
            $userId = Auth::id();
     
            $reservations = Reservation::where('users_id', $userId)->get();
        
            return response()->json([
                'reservations' => $reservations
            ], 200);
        }
        




































    public function update(Request $request, $id)
{
    // Vérifier si l'utilisateur est authentifié
    if (!Auth::check()) {
        return response()->json(['message' => 'Utilisateur non authentifié'], 401);
    }

    // Trouver la réservation à mettre à jour
    $reservation = Reservation::find($id);

    if (!$reservation) {
        return response()->json(['message' => 'Réservation non trouvée'], 404);
    }

    // Vérifier si l'utilisateur est bien le propriétaire de la réservation
    if ($reservation->users_id !== Auth::id()) {
        return response()->json(['message' => 'Accès refusé'], 403);
    }

    // Validation des données
    $request->validate([
        'date' => 'required|date',
        'de' => 'required|date_format:H:i',
        'a' => 'required|date_format:H:i|after:de',
        'places_id' => 'required|exists:places,id',
    ]);

    // Mettre à jour la réservation
    $reservation->update([
        'date' => $request->date,
        'de' => $request->de,
        'a' => $request->a,
        'places_id' => $request->places_id,
    ]);

    return response()->json([
        'message' => 'Réservation mise à jour avec succès',
        'reservation' => $reservation
    ], 200);
}

public function destroy($id)
{
    if (!Auth::check()) {
        return response()->json(['message' => 'Utilisateur non authentifié'], 401);
    }

    // Récupérer la réservation
    $reservation = Reservation::find($id);

    // Vérifier si elle existe
    if (!$reservation) {
        return response()->json(['message' => 'Réservation non trouvée'], 404);
    }

    // Vérifier si l'utilisateur est bien celui qui a réservé
    if ($reservation->users_id !== Auth::id()) {
        return response()->json(['message' => 'Accès interdit'], 403);
    }

    // Supprimer la réservation
    $reservation->delete();

    return response()->json(['message' => 'Réservation supprimée avec succès'], 200);
}


}
