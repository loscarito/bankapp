<?php

namespace App\Form;

use App\Entity\Receptor;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Receptor1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('swift')
            ->add('iban')
            ->add('accountNo')
            ->add('pays')
            ->add('ville')
            ->add('address')
            ->add('email')
            ->add('postal')
            ->add('tel')
            ->add('verificode')
            ->add('isVerify')
            ->add('date')
            ->add('user',EntityType::class,['class'=> User::class,'choice_label' => 'nom'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Receptor::class,
        ]);
    }
}
