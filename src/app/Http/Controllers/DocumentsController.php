<?php

namespace App\Http\Controllers;

use App\Services\DocumentsService;
use Illuminate\Http\Request;

class DocumentsController extends Controller
{
    public function index()
    {
        return view('documents');
    }

    public function store(Request $request)
    {
        $service = new DocumentsService();

        if ($service->uploadFile($request->file('file'))) {
            return response()->json([
                'success' => true,
            ], 200);
        }

        return response()->json([
            'success' => false
        ], 500);

    }
}
