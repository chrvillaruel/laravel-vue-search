<?php
namespace App\Http\Services;

use App\Models\Property;
use Illuminate\Http\Request;
use App\Http\Resources\PropertyCollection;

class PropertyService
{

    public function getAllProperty(Request $request)
    {
        $properties = (new Property)->newQuery();

        if ($request->has('price_min') && $request->has('price_max')) {
            $properties->whereBetween('price', [$request->price_min, $request->price_max]);
        }

        if ( $request->has('search') ) {
            $properties->where('name', 'LIKE', "%{$request->search}%");
        }

        if ( $request->has('bedrooms') && isset($request->bedrooms) ) {
            $properties->where('bedrooms', $request->bedrooms);
        }

        if ( $request->has('bathrooms') && isset($request->bathrooms)) {
            $properties->where('bathrooms', $request->bathrooms);
        }

        if ( $request->has('garages') && isset($request->garages)) {
            $properties->where('garages', $request->garages);
        }

        if ( $request->has('storeys') && isset($request->storeys)) {
            $properties->where('storeys', $request->storeys);
        }


        if (! $properties) {
            throw new \Exception('Sorry, we\'er unable to retrieve properties.', 404);
        }

        return (new PropertyCollection($properties->get()));
    }
}

?>
