<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LocalStorageService
{
    /**
     * Upload an image to local storage
     *
     * @param string $folder The folder to store the image in
     * @param \Illuminate\Http\UploadedFile $image The uploaded image
     * @param string|null $filename Optional filename to use (will generate random name if not provided)
     * @return string The URL to the stored image
     * @throws \Exception If there's an error uploading the image
     */
    public function uploadImg($folder, $image, $filename = null)
    {
        try {
            // Create the folder path
            $path = $folder . '/';
            
            // Use provided filename or generate a random one
            if ($filename) {
                // Extract just the filename without path
                $filename = basename($filename);
            } else {
                // Generate a random filename with the original extension
                $extension = $image->getClientOriginalExtension();
                $filename = Str::random(64) . ($extension ? '.' . $extension : '');
            }
            
            $fullPath = $path . $filename;
            
            // Store the file in the public disk
            Storage::disk('public')->put($fullPath, file_get_contents($image));
            
            // Return the URL to the stored image
            return Storage::disk('public')->url($fullPath);
        } catch (\Exception $error) {
            throw new \Exception('Error uploading ' . Str::beforeLast($folder, 's') . ' image: ' . $error->getMessage());
        }
    }

    /**
     * Delete an image from local storage
     *
     * @param string $folder The folder where the image is stored
     * @param string $file The file URL or path to delete
     * @return bool True if deletion was successful
     * @throws \Exception If there's an error deleting the image
     */
    public function deleteImg($folder, $file)
    {
        try {
            // Extract just the filename from the full path or URL
            $filename = basename($file);
            $path = $folder . '/' . $filename;
            
            // Delete the file from storage
            if (Storage::disk('public')->exists($path)) {
                return Storage::disk('public')->delete($path);
            }
            
            return false;
        } catch (\Exception $error) {
            throw new \Exception('Error deleting ' . Str::beforeLast($folder, 's') . ' image: ' . $error->getMessage());
        }
    }
}