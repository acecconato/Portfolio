<?php

namespace App\EntityListener;

use App\Entity\Image;
use App\Service\ImageUploadHelper;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;

class ImageListener
{
    private $imageUploadHelper;

    public function __construct(ImageUploadHelper $helper)
    {
        $this->imageUploadHelper = $helper;
    }

    public function prePersist(Image $image, LifecycleEventArgs $args)
    {
        $this->imageUploadHelper->upload($image);
    }

    public function preUpdate(Image $image, PreUpdateEventArgs $args)
    {
        $this->imageUploadHelper->upload($image);
    }
}
