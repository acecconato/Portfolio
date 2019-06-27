<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Image;
use App\Service\ImageUploadHelper;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class ImageAdmin extends AbstractAdmin
{
    private $imageUploadHelper;

    public function __construct($code, $class, $baseControllerName, ImageUploadHelper $helper)
    {
        parent::__construct($code, $class, $baseControllerName);
        $this->imageUploadHelper = $helper;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('id')
            ->add('filename')
            ->add('label')
            ->add('createdAt')
            ->add('updatedAt')
            ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('id')
            ->add('filename')
            ->add('label')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('_action', null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->add('file', FileType::class, [
                "required" => false
            ])
            ->add('label', TextType::class)
            ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->with('Metadata')
            ->add('id')
            ->add('filename')
            ->add('label')
            ->end()
            ->with('Preview')
            ->add('preview', null, [
                'template' => 'sonata/image.html.twig'
            ])
            ->end()
            ;
    }

    public function preUpdate($object)
    {
        if (!$object instanceof Image) {
            return;
        }

        $this->manageFileUpload($object);
    }

    public function prePersist($object)
    {
        if (!$object instanceof Image) {
            return;
        }

        $this->manageFileUpload($object);
    }

    public function manageFileUpload(Image $image)
    {
        if ($image->getFile()) {
            $this->imageUploadHelper->refreshUpdated($image);
        }
    }
}
