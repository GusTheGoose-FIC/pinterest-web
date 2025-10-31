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
    public function Condiciones()
    {
        return view('Condiciones');
    }
    public function PoliticasPrivacidad()
    {
        return view('PoliticasPrivacidad');
    }
    public function Comunidad()
    {
        return view('Comunidad');
    }
    public function propiedadIntelectual()
    {
        return view('propiedadIntelectual');
    }
    public function marcaComercial()
    {
        return view('marcaComercial');
    }
    public function Transparencia()
    {
        return view('transparencia');
    }
    public function Mas()
    {
        return view('Mas');
    }
    public function Ayuda()
    {
        return view('Ayuda');
    }
    public function AvisosnoUsuario()
    {
        return view('AvisosnoUsuario');
    }
    public function Liderazgo()
    {
        return view('Liderazgo');
    }
}
