<?php

namespace App\Controller;

use App\Domain\Command\AddSubscriberCommand;
use App\Domain\Command\AddSubscriberHandler;
use App\Domain\Command\DeleteSubscriberCommand;
use App\Domain\Command\DeleteSubscriberHandler;
use App\Domain\Query\ListSubscribersHandler;
use App\Domain\Query\ListSubscribersQuery;
use App\Entity\Subscriber;
use Doctrine\Bundle\DoctrineBundle\Command\Proxy\DelegateCommand;
use Doctrine\Persistence\ObjectManager;
use phpDocumentor\Reflection\Types\Resource_;
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
    /**
     * MailerController constructor.
     * @param MailerInterface $mailer
     */
    public function __construct(private MailerInterface $mailer)
    {
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

        for ($i=0, $size = is_countable($to) ? count($to) : 0; $i < $size; $i++){
            $h=hash('md5',$to[$i]);
            $email = (new Email())
                ->from($from)
                ->to($to[$i])
                ->subject($subject)
                ->html($content.'<br><p><a href="localhost:9999/newsletter/unsubscribe/'.$h.'">Vous desabonné ?</a></p>');
            $this->mailer->send($email);
        }
    }

    /**
     * @Route("/sendNewsletter", name="sendNewsletter")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws TransportExceptionInterface
     */
    public function sendNewsletter(ListSubscribersHandler $handler)
    {

        $query = new ListSubscribersQuery();
        $sub = $handler->handle($query);
        $subs = array();
        foreach ($sub as &$s){
            array_push($subs,$s->getEmail());
        }

        $from = 'farmeetic@gmail.com';
        $to = array('jean@gmail.com','martin@gmail.com');
        $subject = 'Newsletter '.date('H:m d/m:Y');
        $content = 'Hello, today we have new content for you ! [...]';
        $this->sendEmail($from,$subs,$subject,$content);
        return $this->redirectToRoute('home');

    }

    /**
     * @Route("/newsletter", name="newsletter")
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

        if($security->getUser()){
            $sub->setEmail($security->getUser()->getEmail());
        }

        $form = $this->createFormBuilder($sub)
                     ->add('email')
                     ->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $from = 'newsletter@farmeetic.com';
            $to = array($sub->getEmail());
            $subject = 'Newsletter subscription';
            $content = 'Hello, welcome to the newsletter !';
            $this->sendEmail($from,$to,$subject,$content);

            $command = new AddSubscriberCommand($sub);
            $handler->handle($command);

            return $this->redirectToRoute('home');
        }

        return $this->render('mail/newsletter.html.twig', [
            'formEmail'=>$form->createView()
        ]);
    }


    /**
     * @Route("/newsletter/unsubscribe/{code}", name="newsletterUnSub")
     */
    public function unSub(DeleteSubscriberHandler $handler,$code): Response
    {
        if($handler->find($code))
        {
            $command = new DeleteSubscriberCommand($handler->find($code));
            $handler->handle($command);
        }

        return $this->render('mail/unsub.html.twig');
    }
}