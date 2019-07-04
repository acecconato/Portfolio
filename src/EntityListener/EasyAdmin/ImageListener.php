<?php

namespace App\EntityListener\EasyAdmin;

use App\Entity\Image;
use App\Service\FileUploader;
use Symfony\Component\EventDispatcher\GenericEvent;

class ImageListener
{
    /**
     * @var Image
     */
    private $image;

    /**
     * @var FileUploader
     */
    private $fileUploader;

    private $imageUploadPath;

    public function __construct(FileUploader $fileUploader, $imageUploadPath)
    {
        $this->fileUploader = $fileUploader;
        $this->imageUploadPath = $imageUploadPath;
    }

    public function onEasyAdminPrePersist(GenericEvent $event)
    {
        if (!$event->getSubject() instanceof Image) {
            return;
        }

        $this->image = $event->getSubject();
        $filename = $this->fileUploader->upload($this->image->getFile(), $this->imageUploadPath);
        $this->image->setFilename($filename);
    }

    public function onEasyAdminPreUpdate(GenericEvent $event)
    {
        if (!$event->getSubject() instanceof Image) {
            return;
        }

        $this->image = $event->getSubject();
        $filename = $this->fileUploader->upload($this->image->getFile(), $this->imageUploadPath);

        $this->image->setFilename($filename);
        unlink($this->imageUploadPath."/".$this->image->getTempFilename());
    }

    public function onEasyAdminPreRemove(GenericEvent $event)
    {
        if (!$event->getSubject() instanceof Image) {
            return;
        }

        $this->image = $event->getSubject();
        unlink($this->imageUploadPath."/".$this->image->getTempFilename());
    }
}
