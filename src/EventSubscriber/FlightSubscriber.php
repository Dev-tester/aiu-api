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
		    $this->sendEmail($mailer, $ticket->email,
			    [
			    	'subject' => 'Рейс отложен',
				    'text' => 'Извините, ваш рейс отложен',
			    ]);
	    }
    }

	public function onTicketSalesCompleted($event)
	{
		$tickets = $this->getDoctrine()->getRepository(Ticket::class)->findAll();
		$mailer = new Mailer();
		foreach ($tickets as $ticket){
			$this->sendEmail($mailer, $ticket->email,
				[
					'subject' => 'Продажа билетов прекращена',
					'text' => 'Продажа билетов на ваш авиарейс прекращена',
				]);
		}
	}

	public static function getSubscribedEvents()
    {
        return [
            'FlightCancelEvent' => 'onFlightCancelEvent',
	        'TicketSalesCompletedEvent' => 'onTicketSalesCompleted',
        ];
    }

	public function sendEmail(MailerInterface $mailer, $clientEmail, $email): Response
	{
		$email = (new Email())
			->from('hello@example.com')
			->to($clientEmail)
			->subject($email->subject)
			->text($email->text)
			->html("<p>{$email->text}</p>");

		$mailer->send($email);
	}
}
