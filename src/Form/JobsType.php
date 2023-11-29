<?php

namespace App\Form;

use App\Entity\Jobs;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class JobsType extends AbstractType
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
            ->add('titre', TextType::class, $this->configForm("Poste", "form-group", "Poste"))
            ->add('description', TextType::class, $this->configForm("Description", "form-group", "Description"))
            ->add('localisation', TextType::class, $this->configForm("Localisation", "form-group", "Localisation"))
            ->add('salaireMin', IntegerType::class, $this->configForm("Salaire Minimum", "form-group", "Salaire Minimum"))
            ->add('salaireMax', IntegerType::class, $this->configForm("Salaire Maximum", "form-group", "Salaire Maximum"))
            ->add('nomSociete', TextType::class, $this->configForm("Nom de l'entreprise", "form-group", "Nom de l'entreprise"))
            ->add('categorie', ChoiceType::class, [
                'label'=> 'Status',
                'attr'=> [
                    'class'=> 'form-select',
                    'placeholder'=>'Définissez votre status'
                ],
                'choices'=> [
                    'Informatique' => 'Informatique',
                    "Marketing"=> "Marketing",
                    "Web design" => "design",
                    "Comptable"=> "Comptable"
                ], 
                
            ])
            ->add('expireAt', DateType::class, [
                'widget' => 'single_text',
                // this is actually the default format for single_text
                'format' => 'yyyy-MM-dd',

                'label' => 'Fin du poste'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Jobs::class,
        ]);
    }
}
