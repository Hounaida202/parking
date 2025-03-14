<?php

namespace App\Http\Controllers;
use App\Models\Parking;
use Illuminate\Http\Request;

class ParkingController extends Controller
{
    // public function rechercherParking(Request $request)
    // {
    
    //     if ($request->isMethod('POST')) {
    //         $adresse = $request->input('search');
    //         $parkings = Parking::where('adresse', 'LIKE', "%{$adresse}%")->get();
    //     } 
    //     return response()->json([
           
    //     ], 201);   
    //  }


     public function rechercherParking(Request $request)
{
    if ($request->isMethod('POST')) {
        $adresse = $request->input('search');
        $parkings = Parking::where('adresse', 'LIKE', "%{$adresse}%")->get(); 
        
        return response()->json([
            'parkings' => $parkings, 
        ], 200); 
    }
    
    return response()->json([
        'message' => 'Méthode incorrecte', 
    ], 405); 
}



    }
