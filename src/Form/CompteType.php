<?php

namespace App\Form;

use App\Entity\Compte;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CompteType extends AbstractType
{

    private function configForm($label, $class, $placeholder)
    {
        return [
            'label'=>$label,
            'attr'=>[
                'class'=>$class,
                'placeholder'=>$placeholder
            ]
            ];
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, $this->configForm("Nom", "form-group", "Nom"))
            ->add('prenoms', TextType::class, $this->configForm("Prénoms", "form-group", "Prénoms"))
            ->add('email', EmailType::class, $this->configForm("E-mail", "form-group", "E-mail"))
            ->add('status', ChoiceType::class, [
                'label'=> 'Définissez votre status',
                'attr'=> [
                    'class'=> 'form-select'
                ],
                'choices'=> [
                    'Recruteur' => 'Recruteur',
                    "Demandeur d'emploi"=> "Demandeur d'emploi"
                ], 
            
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Compte::class,
        ]);
    }
}
