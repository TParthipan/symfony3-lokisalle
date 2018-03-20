<?php

namespace AppBundle\Controller;

use AppBundle\Form\ContactType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {

    /**
     * @Route("/")
     */
    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $salleRepository = $em->getRepository('AppBundle:Salle');
        $villes = $salleRepository->findVilles();
        $form = $this->createFormBuilder()
                ->add('categorie', ChoiceType::class, ['label' => 'Catégorie',
                    'choices' =>
                    [
                        'Réunion' => 'réunion',
                        'Bureau' => 'bureau',
                        'Formation' => 'formation',
                    ],
                    'required' => false,
                    'placeholder' => 'Choisissez une catégorie',
                ])
                ->add('ville', ChoiceType::class, [
                    'label' => 'Ville',
                    'choices' => array_combine($villes, $villes),
                    'placeholder' => 'Choisissez une ville',
                    'required' => false
                ])
                ->add('capacite', IntegerType::class, [
                    'label' => 'Capacité',
                    'required' => false
                ])
                ->add('prix', IntegerType::class, [
                    'label' => 'Prix',
                    'required' => false
                ])
                ->add('dateD', DateType::class, [
                    'label' => 'Date de départ',
                    'required' => false
                ])
                ->add('dateA', DateType::class, [
                    'label' => 'Date d\'arrivee',
                    'required' => false
                ])
                ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            dump($data);
            //dump($data['categorie']);
            //$annonces = $em->getRepository('AppBundle:Produit')->findBy(['etat' => 'libre']);
            $annonces = $em->getRepository('AppBundle:Produit')->findProduit($data);
        } else {
            $annonces = $em->getRepository('AppBundle:Produit')->findAll();
        }
        //dump($annonces);
        return $this->render('default/index.html.twig', [
                    'annonces' => $annonces, 'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/contact")
     * @param Request $request
     */
    public function contactAction(Request $request, \Swift_Mailer $mailer, \Twig_Environment $twig) {
        $form = $this->createForm(ContactType::class);
        if ($this->getUser()) {
            $form->get('name')->setData($this->getUser()->getPseudo());
            $form->get('email')->setData($this->getUser()->getEmail());
        }

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $data = $form->getData();
                $mail = $mailer->createMessage();

                $mailBody = '<h3>Nouveau message de ' . $data['name'] . '(' . $data['email'] . ')</h3>'
                        . '<p><strong>' . $data['subject'] . '</strong></p>'
                        . '<p>' . nl2br($data['body']) . '</p>';

                //$mailBody=$twig->render('default/mail_body.html.twig',['data'=>$data]);
                $mail
                        ->setSubject('Nouveau message sur votre blog')
                        ->setFrom($data['email'])
                        ->setTo($this->getParameter('contact_email'))
                        ->setBody($mailBody)
                        ->setReplyTo($data['email']);
                $mailer->send($mail);
                $this->addFlash('success', 'Votre message est envoyé');
            } else {
                $this->addFlash('error', 'Le formulaire contient des erreurs');
            }
        }
        return $this->render('default/contact.html.twig', [
                    'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/qui-somme-nous")
     */
    public function quisommenousAction() {
        return $this->render('default/qui-somme-nous.html.twig', [
        ]);
    }

}
