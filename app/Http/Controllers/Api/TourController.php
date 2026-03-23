<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Models\TourTranslation;
use Illuminate\Http\Request;
use SebastianBergmann\Environment\Console;
use Illuminate\Support\Facades\Log;

class TourController extends Controller
{
    // Listar todos los tours (con idioma seleccionado)
    // public function index(Request $request)
    // {
    //     $locale = $request->query('lang', app()->getLocale());

    //     $tours = Tour::with(['translations' => function ($q) use ($locale) {
    //         $q->where('locale', $locale);
    //     }])->get();

    //     return response()->json($tours);
    // }

    public function index(Request $request)
    {
        $locale = $request->query('lang', 'en'); // Idioma por defecto

        // Traer tours con traducciones y sus amenities
        $tours = Tour::with(['translations.amenities'])->get();
        $tours = $tours->map(function ($tour) use ($locale) {
            // Selecciona la traducción del idioma solicitado o EN por defecto
            $translation = $tour->translations->firstWhere('locale', $locale)
                        ?? $tour->translations->firstWhere('locale', 'en');

            // Valores por defecto si no hay traducción
            if (!$translation) {
                return [
                    'id' => $tour->id,
                    'slug'=> $tour->slug,
                    'title' => 'No title',
                    'description' => 'No description',
                    'image' => $tour->image,
                    'regular_price' => null,
                    'descount_price' => null,
                    'amenities' => [],
                ];
            }

            // Manejo seguro de amenities
            $amenities = [];
            if ($translation->relationLoaded('amenities') && $translation->amenities instanceof \Illuminate\Database\Eloquent\Collection) {
                $amenities = $translation->amenities->pluck('name')->toArray();
            }

            return [
                'id' => $tour->id,
                'slug' => $translation->slug,
                'title' => $translation->title ?? 'No title',
                'description' => $translation->description ?? 'No description',
                'image' => $tour->image,
                'regular_price' => $translation->regular_price ?? null,
                'descount_price' => $translation->descount_price ?? null,
                'amenities' => $amenities,
            ];
        });


        return response()->json($tours);
    }

    private function getTemplateBySite(int $site_id): string
    {
        return match ($site_id) {
             1 => 'vtaadventure',
             2 => 'canopyriver',
            default => 'default',
        };
    }

     // Detalle de un tour
    public function show(Request $request, $slug)
    {
        $locale = $request->query('lang', 'es'); // idioma por defecto

        try {
            // Buscar la traducción por slug
            $translation = \App\Models\TourTranslation::where('slug', $slug)->first();

            if (!$translation) {
                return response()->json(['error' => 'Tour no encontrado'], 404);
            }

            $tour = $translation->tour; // relación belongsTo en TourTranslation

            // Intentar obtener traducción en el idioma solicitado
            $localeTranslation = $tour->translations->firstWhere('locale', $locale) ?? $translation;

            $templatePath = $this->getTemplateBySite($tour->site_id);

            return response()->json([
                'id' => $tour->id,
                'template' => $this->getTemplateBySite($tour->site_id),
                'slug' => $localeTranslation->slug ?? $translation->slug,
                'title' => $localeTranslation->title ?? 'No title',
                'description' => $localeTranslation->description ?? 'No description',
                'description_2' => $localeTranslation->description_2 ?? null,
                'image' => $tour->image ?? null,
                'regular_price' => $localeTranslation->regular_price ?? null,
                'descount_price' => $localeTranslation->descount_price ?? null,
                'recommendations' => $localeTranslation->recommendations ?? null,
                'requirements' => $localeTranslation->requirements ?? null,
                // 'recommendations' => $localeTranslation->recommendations ? $localeTranslation->recommendations->pluck('name')->toArray() : [],
                'faq' => $localeTranslation->faq ?? null,
                'info' => $localeTranslation->info ?? null,
            ]);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    // Crear un tour con traducciones
    public function store(Request $request)
    {
        $data = $request->validate([
            'slug' => 'required|unique:tours,slug',
            'image' => 'nullable|string',
            'price' => 'nullable|numeric',
            'translations' => 'required|array',
        ]);

        $tour = Tour::create($data);

        foreach ($data['translations'] as $locale => $translation) {
            TourTranslation::create([
                'tour_id' => $tour->id,
                'locale' => $locale,
                'title' => $translation['title'],
                'description' => $translation['description'] ?? null,
                'amenities' => $translation['amenities'] ?? null,
                'faq' => $translation['faq'] ?? null,
                'info' => $translation['info'] ?? null,
            ]);
        }

        return response()->json($tour->load('translations'), 201);
    }

    public function dashboard()
    {
        return response()->json(
            TourTranslation::latest()->get(),
            200
        );
    }

    // Actualizar un tour y sus traducciones
    public function update(Request $request, $id)
    {
        $tour = Tour::findOrFail($id);

        $data = $request->validate([
            'slug' => 'sometimes|required|string|unique:tours,slug,' . $tour->id,
            'image' => 'nullable|string',
            'price' => 'nullable|numeric',
            'translations' => 'array',
        ]);

        $tour->update($data);

        if (isset($data['translations'])) {
            foreach ($data['translations'] as $locale => $translation) {
                TourTranslation::updateOrCreate(
                    ['tour_id' => $tour->id, 'locale' => $locale],
                    $translation
                );
            }
        }

        return response()->json($tour->load('translations'));
    }

    // Eliminar un tour
    public function destroy($id)
    {
        $tour = Tour::findOrFail($id);
        $tour->delete();

        return response()->json(['message' => 'Tour eliminado correctamente']);
    }
}
