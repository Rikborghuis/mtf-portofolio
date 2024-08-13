<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use App\Models\Post;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;


class ModelController extends Controller
{
    public function display()
    {



        $nr = 1;

        $postsQuery = Post::with(['carinfo', 'condition', 'docu', 'looks', 'techinfo', 'images' => function ($query) use ($nr) {
            $query->where('nr', $nr);
        }]);

        $posts = $postsQuery->get();

        $posts->each(function ($post) use ($nr) {
            $post->images = $post->images->filter(function ($image) use ($nr) {
                return $image->nr == $nr;
            });
        });


        //dd($posts->toArray());
        return Inertia::render('Aanbod', [
            'posts' => $posts
        ]);
    }




    public function json(Request $request)
    {


        //filters
        $filterMerk = $request->input('merk');
        $filterModel = $request->input('model');
        $filterType = $request->input('type');
        $filterCarrosserie = $request->input("carrosserie");
        $filterExteriorColor = $request->input("basiskleur");
        $filterExteriorMaterial = $request->input("laksoort");
        $filterInteriorColor = $request->input("interieurkleur");
        $filterInteriorMaterial = $request->input("bekleding");
        $filterAccessoires = $request->input("accessoires");
        $filterFuel = $request->input("brandstof");
        $filterPrice = $request->input("verkoopprijs_particulier");
        $filterAge = $request->input("bouwjaar");
        $filterMileage = $request->input("tellerstand");
        $filterTransmissie = $request->input("transmissie");
        $filterNew =  $request->input("nieuw_voertuig");
        $filterDiscounted = $request->input("actieprijs");
        $filterSearch = $request->input("search");
        $nr = 1;

        $postsQuery = Post::with(['carinfo', 'condition', 'docu', 'looks', 'techinfo', 'images' => function ($query) use ($nr) {
            $query->where('nr', $nr);
        }]);




        if ($filterMerk) {
            $postsQuery->whereHas('carinfo', function ($query) use ($filterMerk) {
                $query->wherein('merk', $filterMerk);
            });
        }


        if ($filterModel) {
            $postsQuery->whereHas('carinfo', function ($query) use ($filterModel) {
                $query->wherein('model', $filterModel);
            });
        }


        if ($filterType) {
            $postsQuery->whereHas('carinfo', function ($query) use ($filterType) {
                $query->whereIn('type', $filterType);
            });
        }


        if ($filterCarrosserie) {
            $postsQuery->whereHas('carinfo', function ($query) use ($filterCarrosserie) {
                $query->wherein('carrosserie', $filterCarrosserie);
            });
        }

        if ($filterAccessoires) {
            $postsQuery->whereHas('carinfo', function ($query) use ($filterAccessoires) {
                foreach ($filterAccessoires as $term) {
                    $query->where('accessoires', 'LIKE', '%' . $term . '%');
                }
            });
        }

        if ($filterExteriorColor) {
            $postsQuery->whereHas('looks', function ($query) use ($filterExteriorColor) {
                $query->whereIn('basiskleur', $filterExteriorColor);
            });
        }

        if ($filterExteriorMaterial) {
            $postsQuery->whereHas('looks', function ($query) use ($filterExteriorMaterial) {
                $query->whereIn('laksoort', $filterExteriorMaterial);
            });
        }
        if ($filterInteriorColor) {
            $postsQuery->whereHas('looks', function ($query) use ($filterInteriorColor) {
                $query->whereIn('interieurkleur', $filterInteriorColor);
            });
        }

        if ($filterInteriorMaterial) {
            $postsQuery->whereHas('looks', function ($query) use ($filterInteriorMaterial) {
                $query->whereIn('bekleding', $filterInteriorMaterial);
            });
        }


        if ($filterFuel) {
            $postsQuery->whereHas('techinfo', function ($query) use ($filterFuel) {
                $query->wherein('brandstof', $filterFuel);
            });
        }




        if ($filterTransmissie) {
            $postsQuery->whereHas('techinfo', function ($query) use ($filterTransmissie) {
                $query->wherein('transmissie', $filterTransmissie);
            });
        }

        if ($filterNew) {
            $postsQuery->whereHas('condition', function ($query) use ($filterNew) {
                $query->where('nieuw_voertuig', 1);
            });
        }

        if ($filterDiscounted) {
            $postsQuery->whereNotNull('actieprijs');
        }




        if ($filterSearch) {
            $postsQuery->where(function ($query) use ($filterSearch) {
                $searchTerms = explode(" ", $filterSearch);
                foreach ($searchTerms as $term) {
                    $query->whereHas('carinfo', function ($query) use ($term) {
                        $query->where(function ($query) use ($term) {
                            $query->where('merk', 'like', '%' . $term . '%')
                                ->orWhere('model', 'like', '%' . $term . '%');
                        })
                            ->orWhere(function ($query) use ($term) {
                                $query->where('merk', '=', $term)
                                    ->orWhere('model', '=', $term);
                            });
                    });
                }
            });
        }

        if ($filterMerk) {
            $postsQuery->whereHas('carinfo', function ($query) use ($filterMerk) {
                $query->whereIn('merk', $filterMerk);
            });
        }

        if ($filterModel) {
            $postsQuery->whereHas('carinfo', function ($query) use ($filterModel) {
                $query->whereIn('model', $filterModel);
            });
        }

        if ($filterType) {
            $postsQuery->whereHas('carinfo', function ($query) use ($filterType) {
                $query->whereIn('type', $filterType);
            });
        }

        if ($filterCarrosserie) {
            $postsQuery->whereHas('carinfo', function ($query) use ($filterCarrosserie) {
                $query->whereIn('carrosserie', $filterCarrosserie);
            });
        }

        if ($filterAccessoires) {
            $postsQuery->whereHas('carinfo', function ($query) use ($filterAccessoires) {
                foreach ($filterAccessoires as $term) {
                    $query->where('accessoires', 'LIKE', '%' . $term . '%');
                }
            });
        }


        if ($filterExteriorColor) {
            $postsQuery->whereHas('looks', function ($query) use ($filterExteriorColor) {
                $query->whereIn('basiskleur', $filterExteriorColor);
            });
        }

        if ($filterExteriorMaterial) {
            $postsQuery->whereHas('looks', function ($query) use ($filterExteriorMaterial) {
                $query->whereIn('laksoort', $filterExteriorMaterial);
            });
        }

        if ($filterInteriorColor) {
            $postsQuery->whereHas('looks', function ($query) use ($filterInteriorColor) {
                $query->whereIn('interieurkleur', $filterInteriorColor);
            });
        }

        if ($filterInteriorMaterial) {
            $postsQuery->whereHas('looks', function ($query) use ($filterInteriorMaterial) {
                $query->whereIn('bekleding', $filterInteriorMaterial);
            });
        }

        if ($filterFuel) {
            $postsQuery->whereHas('techinfo', function ($query) use ($filterFuel) {
                $query->whereIn('brandstof', $filterFuel);
            });
        }

        if ($request->has('price_from') && $request->has('price_to')) {
            $price_from = $request->input('price_from');
            $price_to = $request->input('price_to');
            $filterPrice = [$price_from, $price_to];
            $postsQuery->whereBetween('verkoopprijs_particulier', $filterPrice);
        }

        if ($request->has('age_from') && $request->has('age_to')) {
            $age_from = $request->input('age_from');
            $age_to = $request->input('age_to');
            $postsQuery->whereHas('condition', function ($query) use ($age_from, $age_to) {
                $query->whereBetween('bouwjaar', [$age_from, $age_to]);
            });
        }

        if ($request->has('mileage_from') && $request->has('mileage_to')) {
            $mileage_from = $request->input('mileage_from');
            $mileage_to = $request->input('mileage_to');
            $postsQuery->whereHas('condition', function ($query) use ($mileage_from, $mileage_to) {
                $query->whereBetween('tellerstand', [$mileage_from, $mileage_to]);
            });
        }

        if ($filterTransmissie) {
            $postsQuery->whereHas('techinfo', function ($query) use ($filterTransmissie) {
                $query->whereIn('transmissie', $filterTransmissie);
            });
        }

        if ($filterNew) {
            $postsQuery->whereHas('condition', function ($query) use ($filterNew) {
                $query->where('nieuw_voertuig', 1);
            });
        }

        if ($filterDiscounted) {
            $postsQuery->whereNotNull('actieprijs');
        }



        $orderByColumn = $request->input('orderByColumn');
        $orderByDirection = $request->input('orderByDirection');

        if ($orderByColumn && $orderByDirection) {
            $postsQuery->orderBy($orderByColumn, $orderByDirection);
        }



        $posts = $postsQuery->get();





        return response()->json(['posts' => $posts]);
    }

    public function search(Request $request)
    {
        $params = [
            'merk' => $request->has('merk') ? collect($request->input('merk'))->pluck('value')->toArray() : null,
            'model' => $request->has('model') ? collect($request->input('model'))->pluck('value')->toArray() : null,
            'type' => $request->has('type') ? collect($request->input('type'))->pluck('value')->toArray() : null,
            'carrosserie' => $request->has('carrosserie') ? collect($request->input('carrosserie'))->pluck('value')->toArray() : null,
            'brandstof' => $request->has('brandstof') ? collect($request->input('brandstof'))->pluck('value')->toArray() : null,
            'transmissie' => $request->has('transmissie') ? collect($request->input('transmissie'))->pluck('value')->toArray() : null,
            'price_from' => $request->input('verkoopprijs_particulier') ? $request->input('verkoopprijs_particulier')[0] : null,
            'price_to' => $request->input('verkoopprijs_particulier') ? $request->input('verkoopprijs_particulier')[1] : null,
            'age_from' => $request->input('bouwjaar') ? $request->input('bouwjaar')[0] : null,
            'age_to' => $request->input('bouwjaar') ? $request->input('bouwjaar')[1] : null,
            'mileage_from' => $request->input('tellerstand') ? $request->input('tellerstand')[0] : null,
            'mileage_to' => $request->input('tellerstand') ? $request->input('tellerstand')[1] : null,
            'basiskleur' => $request->input('basiskleur') ? $request->input('basiskleur') : null,
            'laksoort' => $request->input('laksoort') ? $request->input('laksoort') : null,
            'interieurkleur' => $request->input('interieurkleur') ? $request->input('interieurkleur') : null,
            'bekleding' => $request->input('bekleding') ? $request->input('bekleding') : null,
            'accessoires' => $request->has('accessoires') ? $request->input('accessoires') : null,


            'orderByColumn' => $request->input('orderByColumn'),
            'orderByDirection' => $request->input('orderByDirection'),
        ];

        log::info('dit zijn de params ', $params);
        $queryString = http_build_query($params);

        // Log the value of $queryString

        Log::info('QueryString: ' . $queryString);

        return redirect()->route('aanbod', $queryString);
    }
}
