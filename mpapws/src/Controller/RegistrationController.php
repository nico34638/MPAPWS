<?php

namespace App\Controller;

use App\Domain\Command\RegisterCommand;
use App\Domain\Command\RegisterHandler;
use App\Form\RegisterType;
use Intervention\Image\ImageManagerStatic as Image;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * Class RegistrationController
 * @package App\Controller
 */
class RegistrationController extends AbstractController
{

    /**
     * @Route("/register", name="registration")
     * @param MailerInterface $mailer
     */
    public function register(Request $request,
                             UserPasswordEncoderInterface $passwordEncoder,
                             RegisterHandler $handler, SluggerInterface $slugger): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $file = $form->get('imageFile')->getData();
            if ($file)
            {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();
                // Move the file to the directory where brochures are stored
                try
                {
                    $file->move(
                        $this->getParameter('users_directory'),
                        $newFilename
                    );
                } catch (FileException)
                {
                }

                $path = $path = "uploads/users/" . $newFilename;
                // Resize image
                $img = Image::make($path)->resize(250, 250)->save();


                $user->setProfilImage($path);
            } else
            {
                $user->setProfilImage('https://bootdey.com/img/Content/avatar/avatar7.png');
            }

            if ($form->get('droitUtilisation')->getData() == "true")
            {
                if ($form->get('producer')->getData() == "true")
                {
                    $user->addRoles('ROLE_PRODUCER');
                } else
                {
                    $user->setRoles(['ROLE_USER']);
                }

                $password = $passwordEncoder->encodePassword($user, $user->getPassword());
                $user->setPassword($password);

                $user->setAddress(
                    $form->get('street')->getData() . " " .
                    $form->get('city')->getData() . " " .
                    $form->get('postalCode')->getData() . " "
                );

                $command = new RegisterCommand($user);
                $handler->handle($command);

                $this->addFlash('success', 'Votre compte à bien été enregistré.');


                return $this->redirectToRoute('app_login');
            }

        }

        return $this->render('security/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
