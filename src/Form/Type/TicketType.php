<?php

namespace App\Form\Type;

use App\Entity\Ticket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotNull;

class TicketType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('serial',TextType::class, [
				'constraints' => [
					new NotNull([
						'message' => 'Серия билета не может быть пустой'
					]),
					new Length([
						'max' => 32,
					])
				]
			])
			->add('place_from',TextType::class, [
				'constraints' => [
					new NotNull([
						'message' => 'Место вылета не может быть пустым'
					]),
					new Length([
						'max' => 255,
					]),
				]
			])
			->add('place_to',TextType::class, [
				'constraints' => [
					new NotNull([
						'message' => 'Место прибытия не может быть пустым'
					]),
					new Length([
						'max' => 255,
					]),
				]
			])
			->add('name',TextType::class, [
				'constraints' => [
					new NotNull([
						'message' => 'Имя пассажира не может быть пустым'
					]),
					new Length([
						'max' => 255,
					]),
				]
			])
			->add('surname',TextType::class, [
				'constraints' => [
					new NotNull([
						'message' => 'Фамилия пассажира не может быть пустой'
					]),
					new Length([
						'max' => 255,
					]),
				]
			])
			->add('company',TextType::class, [
				'constraints' => [
					new NotNull([
						'message' => 'Авиакомпания не может быть пустой'
					]),
					new Length([
						'max' => 255,
					]),
				]
			])
			->add('passport_serial',TextType::class, [
				'constraints' => [
					new NotNull([
						'message' => 'Серия билета не может быть пустой'
					]),
					new Length([
						'max' => 32,
					])
				]
			])
			->add('passport_number',TextType::class, [
				'constraints' => [
					new NotNull([
						'message' => 'Серия билета не может быть пустой'
					]),
					new Length([
						'max' => 32,
					])
				]
			])
			->add('flight_number',TextType::class, [
				'constraints' => [
					new NotNull([
						'message' => 'Номер рейса не может быть пустым'
					]),
					new Length([
						'max' => 32,
					])
				]
			])
			->add('flight_date',DateTimeType::class, [
				'widget' => 'single_text',
				'constraints' => [
					new NotNull([
						'message' => 'Дата не может быть пустой'
					])
				]
			])
			->add('created_at')
			->add('price',IntegerType::class, [
				'constraints' => [
					new Length([
						'max' => 20,
					])
				]
			])
			->add('completed');
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => Ticket::class,
		]);
	}
}
