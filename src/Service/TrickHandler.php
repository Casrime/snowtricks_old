<?php

namespace App\Service;

use App\Entity\Trick;
use Doctrine\ORM\EntityManagerInterface;

class TrickHandler
{
    private $fileUploader;
    private $entityManager;

    public function __construct(FileUploader $fileUploader, EntityManagerInterface $entityManager)
    {
        $this->fileUploader = $fileUploader;
        $this->entityManager = $entityManager;
    }

    public function handle(Trick $trick)
    {
        foreach ($trick->getImages() as $image) {
            if(!$image->getId()) {
                $filename = $this->fileUploader->upload($image->getFile());
                $image->setName($filename);
                $image->setTrick($trick);
            }
        }
        $this->entityManager->persist($trick);
        $this->entityManager->flush();
    }
}