<?php

namespace App\Controller;

use App\Form\RegisterType;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class RegistrationController
 * @package App\Controller
 */
class RegistrationController extends AbstractController
{

    /**
     * @Route("/register", name="registration")
     */
    public function register(Request $request,
                             UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            if ($form->get('droitUtilisation')->getData() == "true")
            {
                if ($form->get('producteur')->getData() == "true")
                {
                    $user->addRoles('ROLE_PRODUCER');
                } else
                {
                    $user->setRoles(['ROLE_USER']);
                }

                $password = $passwordEncoder->encodePassword($user, $user->getPassword());
                $user->setPassword($password);

                $user->setAddress(
                    $form->get('numberStreet')->getData() . " " .
                    $form->get('street')->getData() . " " .
                    $form->get('city')->getData() . " " .
                    $form->get('postalCode')->getData() . " "
                );

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                $this->addFlash('success', 'Votre compte à bien été enregistré.');
                return $this->redirectToRoute('app_login');
            }

        }

        return $this->render('security/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
