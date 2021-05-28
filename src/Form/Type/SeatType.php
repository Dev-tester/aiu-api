<?php

namespace App\Form\Type;

use App\Entity\Seat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotNull;

class SeatType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('number',TextType::class, [
				'constraints' => [
					new NotNull([
						'message' => 'Номер места не может быть пустой'
					]),
					new GreaterThan([
						'value' => 0
					]),
					new LessThanOrEqual([
						'value' => 150
					])
				]
			])
			->add('reserved',TextType::class, [
				'constraints' => [
					new Length([
						'max' => 5,
					])
				]
			])
			->add('state',TextType::class, [
				'constraints' => [
					new NotNull([
						'message' => 'Состояние места не может быть пустым'
					]),
					new Length([
						'max' => 255,
					]),
				]
			])
			->add('active',TextType::class, [
				'constraints' => [
					new Length([
						'max' => 5,
					])
				]
			]);
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => Seat::class,
		]);
	}
}
