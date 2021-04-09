<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\PropertyService;

class PropertyController extends Controller
{

    public function index(Request $request)
    {
        try {
            $property = (new PropertyService)->getAllProperty($request);
        } catch (\Exception $e) {
            return response($e->getMessage(), 422);
        }

        return response(
            [
                'property' => $property,
                'error' => false,
                'message' => 'Successfully retrieved properties'
            ],
            200
        );
    }
}
