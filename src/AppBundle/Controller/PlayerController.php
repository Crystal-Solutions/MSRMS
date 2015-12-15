<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Player;


use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PlayerController extends Controller
{
    /**
     * @Route("/players/", name="players_home")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }


    /**
     * @Route("/players/create", name="players_home")
     */
    public function createAction(Request $request)
    {

        $player = new Player(); 

        $form = $this->createFormBuilder($player)
            ->add('name', TextType::class)
            ->add('dateOfBirth', DateType::class)
            ->add('year',TextType::class)
            ->add('departmentId',TextType::class)
            ->add('address',TextType::class)
            ->add('bloodType',TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Create Task'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ... perform some action, such as saving the task to the database

            $player->save();

            return $this->redirectToRoute('task_success');
        }

        // replace this example code with whatever you need
        return $this->render('player/create.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/players/view/{id}", name="player_view")
     */
    public function viewAction($id, Request $request)
    {
        $player =  Player::getOne($id);
        return $this->render('player/view.html.twig', array('player' =>$player));
    }



 
}
