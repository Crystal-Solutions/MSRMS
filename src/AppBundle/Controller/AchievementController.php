<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Achievement;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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