<?php

namespace App\Http\Controllers\api;

use App\Models\City;
use App\Models\Country;
use App\Models\ShippingOption;
use App\Http\Controllers\Controller;

class LocationController extends Controller
{
    public function getCountries()
    {
        return response()->json(Country::all());
    }

    public function getCities($country_id)
    {
        return response()->json(City::where('country_id', $country_id)->get());
    }

    public function getShippingOptions()
    {
        return response()->json(ShippingOption::all());
    }
}
