<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class inicioController extends Controller
{
    public function inicio()
    {
        return view('inicio');
    }
}
