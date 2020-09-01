<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File as FileFacade;

class FileRepository extends Base
{
    protected string $modelClass = File::class;

    private string $fileDir = 'files';

    public function __construct()
    {
        $dirPath = storage_path($this->fileDir);

        if (!is_dir($dirPath)) {
            mkdir($dirPath);
        }
    }

    public function createFromUploadedFile(UploadedFile $file): File
    {
        return new File([
            'size' => $file->getSize(),
            'content_type' => $file->getMimeType(),
            'path' => $file->path(),
        ]);
    }

    public function save(File $entity, array $options = []): bool
    {
        $uploadedFile = new UploadedFile($entity->path, basename($entity->path));
        $uploadedFile->move(
            storage_path($this->fileDir),
            $uploadedFile->getClientOriginalName()
        );

        $entity->path = str_replace(base_path(), '', $uploadedFile->getRealPath());

        if (!$entity->save($options)) {
            FileFacade::delete($uploadedFile->getRealPath());

            return false;
        }

        return true;
    }
}
