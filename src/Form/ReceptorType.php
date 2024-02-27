<?php

namespace App\Form;

use App\Entity\Receptor;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReceptorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('destinationBank')
            ->add('swift')
            ->add('iban')
            ->add('accountNo')
            ->add('pays')
            ->add('ville')
            ->add('address')
            ->add('postal')
            ->add('tel')
            ->add('email',EmailType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Receptor::class,
        ]);
    }
}
