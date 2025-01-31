<?php

namespace App\Services;

use App\Jobs\DocumentsJob;
use App\Models\Category;
use App\Models\Document;
use App\Models\Import;
use Carbon\Carbon;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ImportsService
{
    public function __construct(
        private Import $import      = new Import(),
        private Document $document  = new Document(),
    )
    {}

    public function uploadFile($file) : bool
    {
        $filename       = $file->getClientOriginalName();
        $fileContent    = file_get_contents($file->getRealPath());

        if (Storage::disk('uploads')->put($filename, $fileContent)) {
            $this->import->file_name    = $filename;
            $this->import->path         = 'data/'. $filename;
            $this->import->file_hash    = time() . hash_file(
                'sha512',
                storage_path("data/{$filename}"),
            );
            $this->import->imported_at  = Carbon::now()->toDateTimeString();
            $this->import->save();

            DocumentsJob::dispatch($filename);
            
            return true;
        }

        return false;
    }

    public function execute()
    {
        $imports = $this->import->where('status', 'uploaded')->get();
        foreach ($imports as $import) {
            $file    = Storage::disk('uploads')->get($import->file_name);
            $content = json_decode(Storage::disk('uploads')->get($file));

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

            $import->status = 'processed';
            $import->save();
        }
    }
}
