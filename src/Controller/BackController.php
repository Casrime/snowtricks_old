<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Form\TrickType;
use App\Service\FileUploader;
use App\Service\TrickHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BackController extends AbstractController
{
    /**
     * @Route("/tricks/new", name="add_trick")
     */
    public function addTrick(Request $request, TrickHandler $trickHandler)
    {
        $trick = new Trick();
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $trickHandler->handle($trick);
        }
        return $this->render('back/trick/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/tricks/edit/{id}", name="edit_trick")
     */
    public function editTrick(Trick $trick, Request $request, TrickHandler $trickHandler)
    {
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $trickHandler->handle($trick);
        }
        return $this->render('back/trick/edit.html.twig', [
            'form' => $form->createView(),
            'trick' => $trick
        ]);
    }
}
