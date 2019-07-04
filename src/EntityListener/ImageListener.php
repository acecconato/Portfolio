<?php

namespace App\EntityListener;

use App\Entity\Image;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Asset\Package;

class ImageListener
{
    /**
     * @var Package
     */
    private $assetsHelper;

    public function __construct($assetsHelper)
    {
        $this->assetsHelper = $assetsHelper;
    }

    public function postLoad(Image $image, LifecycleEventArgs $args): void
    {
        $image->setWebView(
            $this->assetsHelper->getUrl("/uploads/images/".$image->getFilename())
        );

        if (!$image->getTempFilename()) {
            $image->setTempFilename($image->getFilename());
        }
    }
}
