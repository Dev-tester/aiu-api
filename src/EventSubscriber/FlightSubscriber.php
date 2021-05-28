<?php

namespace App\EventSubscriber;

use App\Entity\Ticket;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

class FlightSubscriber implements EventSubscriberInterface
{
    public function onFlightCancelEvent($event)
    {
	    $tickets = $this->getDoctrine()->getRepository(Ticket::class)->findAll();
	    $mailer = new Mailer();
	    foreach ($tickets as $ticket){
		    $this->sendEmail($mailer, $ticket->email);
	    }
    }

    public static function getSubscribedEvents()
    {
        return [
            'FlightCancelEvent' => 'onFlightCancelEvent',
        ];
    }

	public function sendEmail(MailerInterface $mailer, $clientEmail): Response
	{
		$email = (new Email())
			->from('hello@example.com')
			->to($clientEmail)
			->subject('Рейс отложен')
			->text('Извините, ваш рейс отложен')
			->html('<p>Извините, ваш рейс отложен</p>');

		$mailer->send($email);
	}
}
