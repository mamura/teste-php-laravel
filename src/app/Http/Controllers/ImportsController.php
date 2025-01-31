<?php

namespace App\Http\Controllers;

use App\Services\ImportsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class ImportsController extends Controller
{
    public function __construct(
        private $service = new ImportsService()
    )
    {}

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
        Artisan::call('queue:start-worker');
        
        return redirect()->back()->with('message', 'Worker iniciado!');
    }

    public function logs()
    {
        // Verifique se o arquivo de log existe
        $logFile = storage_path('logs/imports.log');

        // Verifique se o arquivo de log existe
        if (Storage::disk('local')->exists($logFile)) {
            // Lê o conteúdo do arquivo de log
            $logs = Storage::disk('local')->get($logFile);
        } else {
            $logs = 'Nenhum log encontrado.';
        }

        return response()->json(json_encode($logs));
    }
}
