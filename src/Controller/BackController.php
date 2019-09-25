<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Form\TrickType;
use App\Repository\TrickRepository;
use App\Service\TrickHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BackController extends AbstractController
{
    /**
     * @Route("/", name="admin")
     */
    public function adminHome(TrickRepository $trickRepository)
    {
        return $this->render('back/trick/admin.html.twig', [
           'tricks' => $trickRepository->findAll()
        ]);
    }

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
            $this->addFlash('trick_add', 'La nouvelle figure a bien été ajoutée');
            return $this->redirectToRoute('admin');
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
            $this->addFlash('trick_edit', 'La figure a bien été mise à jour');
            return $this->redirectToRoute('admin');
        }
        return $this->render('back/trick/edit.html.twig', [
            'form' => $form->createView(),
            'trick' => $trick
        ]);
    }
}
