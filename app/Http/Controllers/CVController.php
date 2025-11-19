<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\CV;

class CVController extends Controller
{
    function index()
    {
        return view('cv');
    }
}
