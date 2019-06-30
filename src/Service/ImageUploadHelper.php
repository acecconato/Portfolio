<?php

namespace App\Service;

use App\Entity\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageUploadHelper
{
    private $pathForUploadedImages;

    public function __construct($pathForUploadedImages)
    {
        $this->pathForUploadedImages = $pathForUploadedImages;
    }

    public function upload(Image $image): void
    {
        if (null === $image->getFile()) {
            return;
        }

        /**
         * @var $file UploadedFile
         */
        $file = $image->getFile();

        $generatedFilename = $this->generateUniqueFilename().".".$file->guessExtension();
        $image->setFilename($generatedFilename);

        $file->move($this->pathForUploadedImages, $image->getFilename());
        $image->setFile(null);
    }

    public function refreshUpdated(Image $image): void
    {
        $image->setUpdatedAt(new \DateTime());
    }

    public function generateUniqueFilename(): string
    {
        return md5(uniqid());
    }
}
