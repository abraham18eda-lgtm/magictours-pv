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
                    'regular_price' => $data['regular_price'],
                    'descount_price' => $data['descount_price']
                ]
            );
        }

        return response()->json(['message' => 'Tour actualizado']);
    }

    public function store(StoreTourRequest  $request)
    {
        DB::beginTransaction();

        try {
            // Subir imagen si existe
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('tours', 'public');
            }

            // Crear Tour base
            $tour = Tour::create([
                'image' => $imagePath,
                'site_id' => $request->site_id,
                'price' => $request->price,
                'short_description' => $request->short_description,
                'description' => $request->description,
                'tour_active' => $request->tour_active ?? false, 
            ]);

            // Crear traducciones y asociar amenities
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

                // Asociar amenities si vienen
                if (!empty($data['amenities'])) {
                    $amenityIds = [];
                    foreach ($data['amenities'] as $amenity) {
                        // Crear amenity si no existe
                        $amenityModel = TourAmenity::firstOrCreate(['name' => $amenity]);
                        $amenityIds[] = $amenityModel->id;
                    }
                    $translation->amenities()->sync($amenityIds);
                }
            }

            DB::commit();

            return response()->json([
                'message' => 'Tour creado correctamente',
                'tour' => $tour->load('translations.amenities')
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Error al crear el tour: ' . $e->getMessage()
            ], 500);
        }
        // 1. Crear tour base
        // $tour = Tour::create();

        // 2. Crear traducciones
        // foreach ($request->translations as $locale => $data) {

        //     $translation = $tour->translations()->create([
        //         'locale' => $locale,
        //         'slug' => $data['slug'],
        //         'title' => $data['title'],
        //         'description' => $data['description'] ?? null,
        //         'description_2' => $data['description_2'] ?? null,
        //         'recommendations' => $data['recommendations'] ?? null,
        //         'requirements' => $data['requirements'] ?? null,
        //         'regular_price' => $data['regular_price'],
        //         'descount_price' => $data['descount_price'] ?? null,
        //         'faq' => $data['faq'] ?? null,
        //         'info' => $data['info'] ?? null,
        //     ]);

         
        // }

        // return response()->json([
        //     'message' => 'Tour creado correctamente',
        //     'tour' => $tour->load('translations')
        // ]);
    }
}