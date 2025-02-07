<?php

namespace App\Form;

use App\Entity\Car;
use App\Enum\Motor;
use App\Enum\Places;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;


class CarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TypeTextType::class,  [
                'label' => 'Nom',
            ])
            ->add('description', TypeTextType::class,  [
                'label' => 'Description',
            ])
            ->add('monthly_price', NumberType::class,  [
                'label' => 'Prix mensuel',
            ])
            ->add('daily_price', NumberType::class,  [
                'label' => 'Prix journalier',
            ])
            ->add('places', EnumType::class, [
                'class' => Places::class,
            ])
            ->add('motor', EnumType::class, [
                'class' => Motor::class,
            ])
            ->add('certification', CheckboxType::class, [
                'mapped' => false,
                'label' => "Je certifie l'exactitude des informations fournies",
                'constraints' => [
                    new Assert\IsTrue(message: "Vous devez cocher la case pour ajouter un livre."),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}
