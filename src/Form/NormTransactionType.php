<?php

namespace App\Form;

use App\Entity\NormTransaction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NormTransactionType extends TransactionType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildform($builder, $options);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => NormTransaction::class,
        ]);
    }
}
