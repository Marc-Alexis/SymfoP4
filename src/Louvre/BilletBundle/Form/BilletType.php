<?php

namespace Louvre\BilletBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BilletType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fullname', TextType::class, array('label' => 'Nom complet'))
            ->add('nationalite', CountryType::class, array('label' => 'Nationalité'))
            ->add('birthdate', BirthdayType::class, array(
                'label' => 'Date de naissance',
                'format' => 'ddMMyyyy',
                ))
            ->add('type', ChoiceType::class, array('label' => 'Type de billet', 'choices' => array('Journée' => 'Journée', 'Demi-Journée' => 'Demi-Journée')))
            ->add('tarifreduit', CheckboxType::class, array('label' => 'Tarif Réduit', 'required' => false))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Louvre\BilletBundle\Entity\Billet',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'louvre_billetbundle_billet';
    }


}
