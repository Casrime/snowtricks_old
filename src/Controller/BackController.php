<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Form\Model\TrickFormModel;
use App\Form\TrickType;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BackController extends AbstractController
{
    /**
     * @Route("/tricks/new", name="add_trick")
     */
    public function addTrick(Request $request, FileUploader $fileUploader, EntityManagerInterface $entityManager)
    {
        $trick = new Trick();
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            foreach ($trick->getImages() as $image) {
                $filename = $fileUploader->upload($image->getFile());
                $image->setName($filename);
                $image->setTrick($trick);
            }
            $entityManager->persist($trick);
            $entityManager->flush();
        }
        return $this->render('back/trick/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/tricks/edit/{id}", name="edit_trick")
     */
    public function editTrick(Trick $trick, Request $request, FileUploader $fileUploader, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            foreach ($trick->getImages() as $image) {
                if(!$image->getId()) {
                    $filename = $fileUploader->upload($image->getFile());
                    $image->setName($filename);
                    $image->setTrick($trick);
                }
            }
            $entityManager->persist($trick);
            $entityManager->flush();
        }
        return $this->render('back/trick/edit.html.twig', [
            'form' => $form->createView(),
            'trick' => $trick
        ]);
    }
}
