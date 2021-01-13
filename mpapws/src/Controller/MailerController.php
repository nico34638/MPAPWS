<?php

namespace App\Controller;

use App\Domain\Command\AddSubscriberCommand;
use App\Domain\Command\AddSubscriberHandler;
use App\Entity\Subscriber;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;


class MailerController extends AbstractController
{
    private MailerInterface $mailer;

    /**
     * MailerController constructor.
     * @param MailerInterface $mailer
     */
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }


    /**
     * @param $from
     * @param $to
     * @param $subject
     * @param $content
     * @throws TransportExceptionInterface
     */
    public function sendEmail($from,$to,$subject,$content)
    {
        //$from = 'farmeetic@gmail.com';
        //$to = array('jean@gmail.com','martin@gmail.com');
        //$subject = 'Newsletter 20/1/2021';
        //$content = 'Hello, today we have new content for you ! [...]';

        for ($i=0, $size = count($to); $i < $size; $i++){
            $email = (new Email())
                ->from($from)
                ->to($to[$i])
                ->subject($subject)
                ->text($content);
            $this->mailer->send($email);
        }
    }

    /**
     * @Route("/newsletter", name="newsletter")
     * @param Request $request
     * @param Security $security
     * @param AddSubscriberHandler $handler
     * @return Response
     * @throws TransportExceptionInterface
     */
    public function subToNewsletter(Request $request,AddSubscriberHandler $handler,Security $security): Response
    {
        //$from = 'farmeetic@gmail.com';
        //$to = array('jean@gmail.com');
        //$subject = 'Newsletter 20/1/2021';
        //$content = 'Hello, today we have new content for you ! [...]';
        //$this->sendEmail($from,$to,$subject,$content);

        $sub = new Subscriber();

        $sub->setEmail($security->getUser()->getEmail());

        $form = $this->createFormBuilder($sub)
                     ->add('email')
                     ->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $sub->setCode(hash('md5',$sub->getEmail()));

            $from = 'newsletter@farmeetic.com';
            $to = array($sub->getEmail());
            $subject = 'Newsletter subscription';
            $content = 'Hello, welcome to the newsletter !';
            $this->sendEmail($from,$to,$subject,$content);

            $command = new AddSubscriberCommand($sub);
            $handler->handle($command);

            return $this->redirectToRoute('home'/*,['id'=> 15]*/);
        }

        return $this->render('mail/newsletter.html.twig', [
            'formEmail'=>$form->createView()
        ]);
    }
}