<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class GambarService
{
    public function simpan(UploadedFile $file, string $folder): string
    {
        return $file->store($folder, 'public');
    }

    public function hapus(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}
