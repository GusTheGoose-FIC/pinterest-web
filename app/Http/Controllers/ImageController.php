<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ImageController extends Controller
{
    public function store(Request $request)
    {
        return response()->json(['message' => 'Not implemented'], 501);
    }

    public function show($id)
    {
        return response()->json(['message' => 'Not implemented'], 501);
    }

    public function destroy($id)
    {
        return response()->json(['message' => 'Not implemented'], 501);
    }

    public function getByIdea($ideaId)
    {
        return response()->json(['message' => 'Not implemented'], 501);
    }
}
