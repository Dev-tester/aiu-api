<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerController extends AbstractController
{
	/**
	 * @Route("/email")
	 */
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