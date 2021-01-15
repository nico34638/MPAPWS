<?php

namespace App\Controller;

use App\Domain\Command\ContactFormCommand;
use App\Domain\Command\ContactFormHandler;
use App\Form\ContactType;
use App\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="Nous contacter")
     */
    public function index(Request $request, ContactFormHandler $handler): Response
    {
        $message = new Message();
        $form = $this->createForm(ContactType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Votre message à bien été envoyé.');
            $command = new ContactFormCommand($message);
            $handler->handle($command);
        }


        return $this->render('contact/index.html.twig', [
            'message' => $message,
            'form' => $form->createView()
        ]);
    }
}
