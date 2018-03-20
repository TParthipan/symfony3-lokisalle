<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SalleType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('titre', TextType::class, ['label' => 'Titre'])
                ->add('description', TextareaType::class, ['label' => 'Description'])
                ->add('photo', FileType::class, ['label' => 'Image', /* champ optionnel */ 'required' => FALSE])
                ->add('pays', TextType::class, ['label' => 'Pays'])
                ->add('ville', TextType::class, ['label' => 'Ville'])
                ->add('adresse', TextType::class, ['label' => 'Adresse'])
                ->add('cp', TextType::class, ['label' => 'Code postal'])
                ->add('capacite', TextType::class, ['label' => 'Capacité'])
                ->add('categorie', ChoiceType::class, [
                    'choices' =>
                    [
                        'Réunion' => 'réunion',
                        'Bureau' => 'bureau',
                        'Formation' => 'formation',
                    ]
        ]);
        //$option['data']=l'entité article
        if (!is_null($options['data']->getPhoto())) {
            $builder->add(
                    'remove_photo', CheckboxType::class, [
                'label' => 'Supprimer la photo',
                'required' => FALSE,
                //champ non mappé avec l'entité article
                'mapped' => FALSE
                    ]
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Salle'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'appbundle_salle';
    }

}
