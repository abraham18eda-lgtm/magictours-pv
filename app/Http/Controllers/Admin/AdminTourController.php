<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tour;
use App\Models\ToursTranslation;

class AdminTourController extends Controller
{
    public function index()
    {
          return \App\Models\Tour::with('translations')->get();
        // return Tour::with('translations','translations.amenities')->get();
    }
    public function show($id)
    {
        return \App\Models\Tour::with('translations')->findOrFail($id);
    }

    // public function update(Request $request, Tour $tour)
    // {
    //     $tour->update($request->only([
    //         'price',
    //         'short_description',
    //         // 'description'
    //     ]));

    //     return response()->json($tour);
    // }
    public function update(Request $request, $id)
    {
        $tour = \App\Models\Tour::findOrFail($id);

        foreach ($request->translations as $locale => $data) {
            $tour->translations()->updateOrCreate(
                ['locale' => $locale],
                [
                    'title' => $data['title'],
                    'regular_price' => $data['regular_price']
                ]
            );
        }

        return response()->json(['message' => 'Tour actualizado']);
    }

    public function store(Request $request)
    {
        // 1. Crear tour base
        $tour = Tour::create();

        // 2. Crear traducciones
        foreach ($request->translations as $locale => $data) {

            $translation = $tour->translations()->create([
                'locale' => $locale,
                'slug' => $data['slug'],
                'title' => $data['title'],
                'description' => $data['description'] ?? null,
                'description_2' => $data['description_2'] ?? null,
                'recommendations' => $data['recommendations'] ?? null,
                'requirements' => $data['requirements'] ?? null,
                'regular_price' => $data['regular_price'],
                'descount_price' => $data['descount_price'] ?? null,
                'faq' => $data['faq'] ?? null,
                'info' => $data['info'] ?? null,
            ]);

            // Aquí luego puedes guardar amenities si quieres
        }

        return response()->json([
            'message' => 'Tour creado correctamente',
            'tour' => $tour->load('translations')
        ]);
    }
}