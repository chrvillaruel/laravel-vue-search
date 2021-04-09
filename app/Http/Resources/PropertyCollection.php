<?php

namespace App\Http\Resources;
use App\Models\Property;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PropertyCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $property = new Property();
        return [
            'data' => $this->collection,
            'price_min' => 0,
            'price_max' => intval($property::max('price')) ,
        ];
    }

}
