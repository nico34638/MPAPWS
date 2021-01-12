<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class MailerController extends AbstractController
{
    /**
     * @param MailerInterface $mailer
     * @param $from
     * @param $to
     * @param $subject
     * @param $content
     * @throws TransportExceptionInterface
     */
    public function sendEmail($from,$to,$subject,$content,MailerInterface $mailer)
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
            $mailer->send($email);
        }
    }

    /**
     * @Route("/mail", name="m")
     * @return Response
     */
    public function index(): Response
    {
        $from = 'farmeetic@gmail.com';
        $to = array('jean@gmail.com');
        $subject = 'Newsletter 20/1/2021';
        $content = 'Hello, today we have new content for you ! [...]';
        $this->sendEmail($from,$to,$subject,$content);
        return $this->render('mail/mail.html.twig', [
        ]);
    }
}