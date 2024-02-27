<?php

namespace App\Form;

use App\Entity\IntlTransaction;
use App\Entity\Receptor;
use App\Repository\ReceptorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security as Security;

class IntlTransactionType extends AbstractType
{
    private $security;
    private $receptors;
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description')
            ->add('Amount')
            ->add('recipient',EntityType::class,['class'=> Receptor::class,'choices' =>  $this->receptors, 'choice_label'=> function($recipient){return $recipient->getNom()." ".$recipient->getPrenom();} ])
        ;
    }
    public function __construct(Security $security)
    {
        $this->receptors=new ArrayCollection();
        $this->security=$security;
        $receptors=$this->security->getUser()->getUser()->getReceptors();
        foreach ($receptors as $receptor){
            if ($receptor->getIsVerify()== true){
                $this->receptors[]=$receptor;
            }
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => IntlTransaction::class,
        ]);
    }
}
