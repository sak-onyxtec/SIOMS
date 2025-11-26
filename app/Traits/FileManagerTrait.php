<?php

namespace App\Traits;

trait FileManagerTrait

{
    public function upload($path, $file, $before = null)
    {
        if ($before) {
            $this->removeImage($path, $before);
        }

        $filename = time() . '.' . $file->getClientOriginalExtension();
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
