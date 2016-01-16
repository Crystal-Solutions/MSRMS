<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Achievement;
use AppBundle\Entity\Sport;
use AppBundle\Entity\PlayerInvolvedInSport;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AchievementController extends Controller{

    /**
     * @Route("/achievement/", name="achievement_home")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('achievement/create.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }


//lets use this to create achievements for multiple players ??-Shanika
    /**
     * @Route("/achievement/create", name="achievement_create")
     */
    public function createAction(Request $request)
    {

        $achievement = new Achievement();

        $form = $this->createFormBuilder($achievement)
            ->add('title', TextType::class)
            ->add('description', TextType::class)
            ->add('achievedDate', DateType::class)
            ->add('save', SubmitType::class, array('label' => 'Create Achievement'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ... perform some action, such as saving the task to the database

            $achievement->save();

            return $this->redirectToRoute('task_success');
        }


        // replace this example code with whatever you need
        return $this->render('achievement/create.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/achievement/create/{p_id}", name="achievement_create_single")
     */
    public function createsingleAction($p_id,Request $request)
    {
        //Generate required data for the form ----------------------- For choices

        // $involments =  playerInvolvedInSport::getplayerAll($p_id);
        // $involmentIds = array();
        // foreach ($involments as $involment) {
        //     $involmentIds[Sport::getOne($involment->getSport())->getName()] = $involment->getId(); 
        // }

        $involments =  PlayerInvolvedInSport::getAll();
        $involmentIds = array();
        foreach ($involments as $involment) {
            $involmentIds[$involment->getSport()] = $involment->getId(); 
        }

        $achievement = new Achievement();

        $form = $this->createFormBuilder($achievement)
            ->add('player_involved_in_sport',ChoiceType::class, array(
            'choices'  => $involmentIds,
            'choices_as_values' => true,
            'label'=>'Sport'
                ))
            ->add('title', TextType::class)
            ->add('description', TextType::class)
            ->add('achievedDate', DateType::class)
            ->add('save', SubmitType::class, array('label' => 'Create Achievement'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ... perform some action, such as saving the task to the database

            $achievement->save();

            return $this->redirectToRoute('task_success');
        }


        // replace this example code with whatever you need
        return $this->render('achievement/createsingle.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/achievement/view/{id}", name="achievement_view")
     */
    public function viewAction($id,Request $request)
    {
        //give the id of the person we need to view
        $ach = Achievement::getOne($id);

        return $this->render('achievement/view.html.twig', array('achievement' => $ach));
    }

    /**
     * @Route("/achievement/view", name="achievement_viewAll")
     */
    public function viewAllAction(Request $request)
    {
        $achievements = Achievement::getAll();

        return $this->render('achievement/viewall.html.twig', array('achievements' => $achievements));
    }
}