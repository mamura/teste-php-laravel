<?php

namespace App\Http\Controllers;

use App\Services\ImportsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class ImportsController extends Controller
{
    private $service;
    
    public function __construct(ImportsService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('imports');
    }

    public function show()
    {
        return view('process');
    }

    public function store(Request $request)
    {
        if ($this->service->uploadFile($request->file('file'))) {
            return response()->json([
                'success' => true,
            ], 200);
        }

        return response()->json([
            'success' => false
        ], 500);

    }

    public function process()
    {
        $exitCode = Artisan::call('queue:start-worker');
        
        return response()->json([
            'success' => $exitCode === 0,
        ]);
    }

    public function logs()
    {
        $logFile = storage_path('logs/imports.log');

        if (file_exists($logFile)) {
            // Lê o conteúdo do arquivo de log
            $logs = file_get_contents($logFile);
        } else {
            $logs = 'Nenhum log encontrado.';
        }

        return response()->json(['logs' => $logs], 200);
    }
}
