<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\View\View;


class Controller extends 
{
    $users = DB::table('users')->get()->toJson();
    dd($users);
   
}
