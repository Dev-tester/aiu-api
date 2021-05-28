<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Entity\Seat;
use App\Form\Type\SeatType;
use App\Form\Type\TicketType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FlightController extends ApiController
{
	/**
	 * Создаёт новую бронь места на рейсе
	 *
	 *  Если не установлен friendsofsymfony/rest-bundle
	    необходимо перед $form->handleRequest($request); добавить блок кода

	  	$data = $request->toArray();
		$request->request->set('email',$data['email']);
		$request->request->set('phone',$data['phone']);

	  	чтобы корректно заполнялась форма <- request (content-type=application/json)
	 *
	 * @param Request $request HTTP запрос
	 * @return object экземпляр ответа (созданный аккаунт)
	 */
	public function bookAction(Request $request): Response
	{
		// заносим в таблицу мест
		$seatId = $request->get('sid');

		$seat = $this->getDoctrine()->getRepository(Seat::class)->findOneBy([
			'id' => $seatId,
			'active' => true
		]);

		if (!$seat || $seat->getReserved()){
			throw new NotFoundHttpException("Место {$seatId} уже занято");
		}

		$seat->setReserved(true);

		$this->getDoctrine()->getManager()->persist($seat);
		$this->getDoctrine()->getManager()->flush();

		// заносим в таблицу билетов
		$form = $this->buildForm(TicketType::class);

		$form->handleRequest($request);

		if (!$form->isSubmitted() || !$form->isValid()){
			return $this->respond($form,Response::HTTP_BAD_REQUEST);
		}

		/* @var Ticket $Ticket */
		$Ticket = $form->getData();

		$Ticket->setSeat($seat);
		$Ticket->setCompleted(null);

		$this->getDoctrine()->getManager()->persist($Ticket);
		$this->getDoctrine()->getManager()->flush();

		return $this->respond($Ticket);
	}

	/**
	 * Отменяет/снимает бронь
	 *
	 * @param Request $request HTTP запрос
	 *
	 * @throws NotFoundHttpException
	 *
	 * @return Response экземпляр ответа (отменённая бронь)
	 */
	public function cancelBookAction(Request $request): Response
	{
		$seatId = $request->get('sid');

		$seat = $this->getDoctrine()->getRepository(Seat::class)->findOneBy([
			'id' => $seatId,
			'active' => true
		]);

		if (!$seat){
			throw new NotFoundHttpException("Место {$seatId} недоступно");
		}

		if (!$seat->getReserved()){
			throw new NotFoundHttpException("Ошибка снятия брони с места {$seatId}, место свободно");
		}

		$seat->setReserved(null);

		$this->getDoctrine()->getManager()->persist($seat);
		$this->getDoctrine()->getManager()->flush();

		$Ticket = $this->getDoctrine()->getRepository(Ticket::class)->findOneBy([
			'seat' => $seatId
		]);

		if (!$Ticket){
			throw new NotFoundHttpException("Запись о брони {$seatId} не найдена");
		}

		$this->getDoctrine()->getManager()->remove($Ticket);
		$this->getDoctrine()->getManager()->flush();

		return $this->respond(['deleted' => $seatId]);
	}

	/**
	 * Покупка билета на рейс
	 *
	 *  Если не установлен friendsofsymfony/rest-bundle
		необходимо перед $form->handleRequest($request); добавить блок кода

		$data = $request->toArray();
		$request->request->set('email',$data['email']);
		$request->request->set('phone',$data['phone']);

		чтобы корректно заполнялась форма <- request (content-type=application/json)
	 *
	 * @param Request $request HTTP запрос
	 * @return object экземпляр ответа (созданный аккаунт)
	 */
	public function saleAction(Request $request): Response
	{
		$seatId = $request->get('sid');

		$seat = $this->getDoctrine()->getRepository(Seat::class)->findOneBy([
			'id' => $seatId,
			'active' => true
		]);

		if (!$seat){
			throw new NotFoundHttpException("Место {$seatId} недоступно");
		}

		$Ticket = $this->getDoctrine()->getRepository(Ticket::class)->findOneBy([
			'seat' => $seatId
		]);

		if ($seat->getReserved()
			&&
				($Ticket->getPassportSerial() != $request->request->get('passport_serial')
				||
				$Ticket->getPassportNumber() != $request->request->get('passport_number'))
		){
			throw new NotFoundHttpException("Место {$seatId} уже забронировано на другого пассажира");
		}

		if ($Ticket->getCompleted()){
			throw new NotFoundHttpException("Покупка места {$seatId} уже оформлена ранее");
		}

		$Ticket->setCompleted(true);

		$this->getDoctrine()->getManager()->persist($Ticket);
		$this->getDoctrine()->getManager()->flush();

		return $this->respond($Ticket);
	}

	/**
	 * Возврат купленного билета
	 *
	 * @param Request $request HTTP запрос
	 *
	 * @throws NotFoundHttpException
	 *
	 * @return Response экземпляр ответа (отменённая бронь)
	 */
	public function returnAction(Request $request): Response
	{
		$seatId = $request->get('sid');

		$seat = $this->getDoctrine()->getRepository(Seat::class)->findOneBy([
			'id' => $seatId,
			'active' => true
		]);

		if (!$seat){
			throw new NotFoundHttpException("Место {$seatId} недоступно");
		}

		$Ticket = $this->getDoctrine()->getRepository(Ticket::class)->findOneBy([
			'seat' => $seatId
		]);

		if ($seat->getReserved()
			&&
				($Ticket->getPassportSerial() != $request->request->get('passport_serial')
				||
				$Ticket->getPassportNumber() != $request->request->get('passport_number'))
		){
			throw new NotFoundHttpException("Место {$seatId} забронировано на другого пассажира");
		}

		if (!$Ticket->getCompleted()){
			throw new NotFoundHttpException("Покупка места {$seatId} не была завершена");
		}

		$seat->setReserved(null);
		$ticketId = $Ticket->getId();

		$this->getDoctrine()->getManager()->remove($Ticket);
		$this->getDoctrine()->getManager()->flush();

		return $this->respond(['returned' => $ticketId]);
	}
}
