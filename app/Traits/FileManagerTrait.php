<?php

namespace App\Traits;

trait FileManagerTrait

{
    public function upload($path, $file, $before = null)
    {
        if ($before) {
            $this->removeImage($path, $before);
        }

        // Generate unique filename using timestamp, random string, and original filename hash
        $extension = $file->getClientOriginalExtension();
        $uniqueId = uniqid() . '_' . mt_rand(1000, 9999);
        $filename = time() . '_' . $uniqueId . '.' . $extension;
        $file->storeAs($path, $filename, 'public'); // store in storage/app/public/...

        return $filename;
    }

    public function removeImage($path, $before)
    {
        $filePath = public_path('storage/' . $path . '/' . $before);

        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
}
