<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


if (!function_exists('customUpload')) {
    function customUpload(UploadedFile $mainFile, string $uploadPath, ?int $reqWidth = null, ?int $reqHeight = null): array
    {
        try {
            $originalName = pathinfo($mainFile->getClientOriginalName(), PATHINFO_FILENAME);
            $fileExtention = $mainFile->getClientOriginalExtension();
            $currentTime = Str::random(10) . time();
            $name = Str::limit($originalName, 100);
            $fileName = $currentTime . '.' . $fileExtention;
            $fullUploadPath = "public/$uploadPath";

            // Ensure directory exists
            // Ensure directory exists
            if (!Storage::exists($fullUploadPath)) {
                // Create directory
                $localPath = storage_path("app/$fullUploadPath");
                if (!mkdir($localPath, 0755, true)) {
                    abort(404, "Failed to create the directory: $fullUploadPath");
                }
                // Ensure directory permissions are set correctly
                chmod($localPath, 0755);
            }

            // Store the file
            try {
                $mainFile->storeAs($fullUploadPath, $fileName);
                $filePath = "$uploadPath/$fileName";
            } catch (\Exception $e) {
                abort(500, "Failed to store the file: " . $e->getMessage());
            }

            // if (!is_dir("public/$uploadPath")) {
            //     if (!mkdir("public/$uploadPath", 0777, true)) {
            //         abort(404, "Failed to create the directory: public/$uploadPath");
            //     }
            //     chmod($uploadPath, 0777); // Reset umask to default (optional)
            // }

            // $mainFile->storeAs("public/$uploadPath", $fileName);
            // $filePath = "$uploadPath/$fileName";

            $output = [
                'status'         => 1,
                'file_name'      => $fileName,
                'file_extension' => $mainFile->getClientOriginalExtension(),
                'file_size'      => $mainFile->getSize(),
                'file_type'      => $mainFile->getMimeType(),
                'file_path'      => $filePath,
            ];

            return array_map('htmlspecialchars', $output);
        } catch (\Exception $e) {
            return [
                'status' => 0,
                'error_message' => $e->getMessage(),
            ];
        }
    }
}


if (!function_exists('handaleFileUpload')) {
    /**
     * Handle file upload.
     *
     * @param UploadedFile $file
     * @param string $folder
     * @return string
     */
    function handaleFileUpload(UploadedFile $file, $folder = 'default')
    {
        if (!$file->isValid()) {
            abort(422, 'Invalid file');
        }

        $extension = $file->getClientOriginalExtension();
        $folderType = in_array($extension, ['jpg', 'jpeg', 'png', 'gif']) ? 'images' : 'files';

        $path = Storage::disk('public')->put("$folderType/$folder", $file);

        if (!$path) {
            abort(500, 'Error occurred while moving the file');
        }

        // Return only the file path as a string
        return $path;
    }
}


if (!function_exists('handleFileUpdate')) {
    /**
     * Handle file upload and deletion of old files.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $fileKey
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $directory
     * @return string|null
     */
    function handleFileUpdate($request, $fileKey, $model, $directory)
    {
        if ($request->hasFile($fileKey)) {
            $oldFilePath = $model->$fileKey;
            if ($oldFilePath && File::exists(storage_path('app/public/' . $oldFilePath))) {
                File::delete(storage_path('app/public/' . $oldFilePath));
            }
            return handaleFileUpload($request->file($fileKey), $directory);
        }
        return $model->$fileKey;
    }
}


if (!function_exists('noImage')) {
    function noImage()
    {
        return 'https://static.vecteezy.com/system/resources/thumbnails/004/141/669/small/no-photo-or-blank-image-icon-loading-images-or-missing-image-mark-image-not-available-or-image-coming-soon-sign-simple-nature-silhouette-in-frame-isolated-illustration-vector.jpg';
    }
}
