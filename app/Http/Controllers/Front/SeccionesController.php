<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SeccionesController extends Controller
{
    public function indexServicios()
    {
        return view('front.servicios');
    }
}
