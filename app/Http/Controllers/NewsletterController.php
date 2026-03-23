<?php

namespace App\Http\Controllers;

// use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Newsletter;

class NewsletterController extends Controller
{
    //
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:190',
            'email' => 'required|email|unique:newsletters,email',
        ]);

        $newsletter = Newsletter::create([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return response()->json([
            'message' => '¡Gracias por suscribirte!',
            // 'data' => $newsletter
        ]);
    }
}
