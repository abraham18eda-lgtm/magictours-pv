<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'email' => 'required|email|max:255',
            'tour' => 'required|string|max:255',
            'date' => 'required|date',
            'adults' => 'required|integer|min:1',
            'children' => 'required|integer|min:0',
        ]);

        $booking = Booking::create($request->all());

        return response()->json([
            'message' => 'Reserva creada correctamente',
            'booking' => $booking
        ], 201);
    }

     public function index()
    {
        $bookings = Booking::orderBy('created_at', 'desc')->get();
        return response()->json($bookings);
    }
}
