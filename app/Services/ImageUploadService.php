<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ImageUploadService
{
    public function upload($file, $oldImage)
    {
        $directory = "public/img/profile/" . Auth::user()->id;
        $fileName = $this->generateFileName($file);
        $path = $file->storeAs($directory, $fileName);
        $oldImagePath = $directory . '/' . $oldImage;

        if (Storage::exists($oldImagePath)) {
            $this->deleteImage($oldImagePath);
        }

        return $path;
    }

    private function deleteImage($path)
    {
        if ($path && Storage::exists($path)) {
            Storage::delete($path);
        }
    }

    private function generateFileName($file)
    {
        $extension = $file->getClientOriginalExtension();
        $fileName = time() . '.' . $extension;

        return $fileName;
    }
}
