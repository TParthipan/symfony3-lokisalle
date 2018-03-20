<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MembreType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('pseudo', TextType::class, ['label' => 'Pseudo'])
                ->add('mdpclair', RepeatedType::class, [
                    'type' => PasswordType::class,
                    'first_options' => ['label' => 'Mot de passe'],
                    'second_options' => ['label' => 'Confirmation de mot de passe'],
                    //attribut required dans le champ de formulaire si le formulaire
                    //a été créé avec "registration" dans ses groupes de validation
                    'required' => in_array('registration', (array) $options['validation_groups'])])
                ->add('nom', TextType::class, ['label' => 'Nom'])
                ->add('prenom', TextType::class, ['label' => 'Prenom'])
                ->add('email', EmailType::class, ['label' => 'Email'])
                ->add('civilite', ChoiceType::class,[
                        'choices' => ['Monsieur' => 'm','Madame' => 'f']
                    ]
                )
//          ->add('role')
//          ->add('dateEnregistrement')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Membre'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'appbundle_membre';
    }

}
