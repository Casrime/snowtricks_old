<?php

namespace App\Controller;

use App\Form\TrickType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BackController extends AbstractController
{
    /**
     * @Route("/tricks/new", name="add_trick")
     */
    public function addTrick()
    {
        $form = $this->createForm(TrickType::class);
        return $this->render('back/trick/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
