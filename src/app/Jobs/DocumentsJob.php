<?php

namespace App\Jobs;

use App\Models\Category;
use App\Models\Document;
use App\Services\DocumentsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DocumentsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $filePath;

    /**
     * Create a new job instance.
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $file       = Storage::disk('uploads')->get($this->filePath);
        $content    = json_decode(Storage::disk('uploads')->get($file));

        foreach($content->documentos as $documento) {
            $category = new Category();

            if ($category->where('name', $documento->categoria)->exists()) {
                $categoria = $category->where('name', $documento->categoria)->first();
            } else {
                $category->name = $documento->categoria;
                $categoria = $category->save();
            }

            $document = new Document();
            $document->category_id  = $categoria->id;
            $document->title        = $documento->titulo;
            $document->contents     = $documento->conteúdo;
            $document->save();
        }

        $newPath = 'processed_files/' . basename($this->filePath);
        
        // Move o arquivo para a nova pasta
        if (Storage::move($this->filePath, $newPath)) {
            Log::info('Arquivo movido para a pasta processed_files.');
        } else {
            Log::error('Erro ao mover o arquivo para a pasta processed_files.');
        }
    }
}
