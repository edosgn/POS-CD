<?php 

namespace AppBundle\Service;

use Symfony\Component\Templating\EngineInterface;

class Mails
{
    private $mailer;
    private $templating;

    function __construct( \Swift_Mailer $mailer, EngineInterface $templating) {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    public function sendEmail($subject,$to,$data,$plantilla){
        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom('noreply@floristeriacristiandior.com')
            ->setTo($to)
            ->setBody(
                $this->templating->render(
                    $plantilla,
                    $data
                ), 'text/html'
            )
            ->setPriority(2);

        //Enviamos el correo, en caso que hubo un error lo mostramos
        if(!$this->mailer->send($message)){
            return $this->mailer->ErrorInfo;
        }else{ 
            return true;
        }
    }
}