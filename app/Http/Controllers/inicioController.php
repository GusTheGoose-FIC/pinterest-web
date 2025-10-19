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

    public function Información()
    {
        return view('Información');
    }
     public function empresa()
    {
        return view('empresa');
    }
     public function Create()
    {
        return view('Create');
    }
     public function News()
    {
        return view('News');
    }
      public function Login()
    {
        return view('Login');
    }
        public function Registro()
        {
            return view('Registro');
        }
}
