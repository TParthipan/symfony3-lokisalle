<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('produit', EntityType::class, [
                    'label' => 'Produit',
                    //nom de l'entité
                    'class' => 'AppBundle:Produit',
                    //nom du champ qui va s'afficher dans les option
                    'choice_label' => 'salle',
                    'placeholder' => 'Choisissez un produit'
                ])
                ->add('membre', EntityType::class, [
                    'label' => 'Membre',
                    //nom de l'entité
                    'class' => 'AppBundle:Membre',
                    //nom du champ qui va s'afficher dans les option
                    'choice_label' => 'pseudo',
                    'placeholder' => 'Choisissez un membre'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Commande'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'appbundle_commande';
    }

}
