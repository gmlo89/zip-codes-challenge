<?php

namespace App\Http\Controllers;

use App\Models\ZipCode;
use Illuminate\Http\Request;

class ZipCodeController extends Controller
{
    /**
     * Return a zip code information
     *
     * @param ZipCode $zipCode
     * @return Json
     */
    public function index(ZipCode $zipCode)
    {
        return $zipCode->load('federalEntity', 'settlements.settlementType', 'municipality');
    }
}
