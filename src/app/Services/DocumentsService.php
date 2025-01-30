<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class DocumentsService
{
    public function uploadFile($file)
    {
        $filename   = $file->getClientOriginalName();
        $path       = hash( 'sha256', time());

        if (Storage::disk('uploads')->put($path . '/' . $filename, File::get($file))) {
            return true;
        }

        return false;
    }
}
