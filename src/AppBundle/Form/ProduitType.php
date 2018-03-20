<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('dateArrivee', DateType::class, [
                    'label' => 'Date d\'arrivee',
                ])
                ->add('dateDepart', DateType::class, [
                    'label' => 'Date de départ'
                ])
                ->add('prix', IntegerType::class, ['label' => 'Prix'])
                ->add('etat', ChoiceType::class, [
                    'choices' =>
                    [
                        'Libre' => 'libre',
                        'Réserver' => 'reserver',
            ]])
                ->add('salle', EntityType::class, [
                    'label' => 'Salle',
                    //nom de l'entité
                    'class' => 'AppBundle:Salle',
                    //nom du champ qui va s'afficher dans les option
                    'choice_label' => 'Titre',
                    'placeholder' => 'Choisissez une salle'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Produit'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'appbundle_produit';
    }

}
