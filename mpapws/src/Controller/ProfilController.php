<?php

namespace App\Controller;

use App\Domain\Command\RegisterCommand;
use App\Domain\Command\RegisterHandler;
use App\Form\ModifyProfilType;
use Intervention\Image\ImageManagerStatic as Image;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * Class ProfilController
 * @package App\Controller
 */
class ProfilController extends AbstractController
{

    /**
     * @Route("/profil/modif-profil", name="modif-profil")
     */
    public function modif(Request $request,
                          UserPasswordEncoderInterface $passwordEncoder,
                          RegisterHandler $handler,
                          SluggerInterface $slugger): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ModifyProfilType::class, $user);
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

                $img = Image::make($path)->resize(250, 250)->save();


                $user->setProfilImage($path);
            } else
            {
                $user->setProfilImage('https://bootdey.com/img/Content/avatar/avatar7.png');
            }
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $command = new RegisterCommand($user);
            $handler->handle($command);

            $this->addFlash('success', 'Votre compte à bien été modifié.');
            return $this->redirectToRoute('profil');

        }
        return $this->render('profil/modif.html.twig', [
            'user' => $this->getUser(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/profil", name="profil")
     */
    public function index(): Response
    {
        return $this->render('profil/profil.html.twig', [
            'user' => $this->getUser()
        ]);
    }
}
