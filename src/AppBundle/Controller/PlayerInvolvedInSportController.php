<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\PlayerInvolvedInSport;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class PlayerInvolvedInSportController extends Controller
{
    /**
     * @Route("/playerInvolvedInSport/", name="playerInvolvedInSport_home")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->redirectToRoute('playerInvolvedInSport_viewAll');
    }

    /**
     * @Route("/playerInvolvedInSport/create", name="playerInvolvedInSport_create")
     */
    public function createAction(Request $request)
    {
    	$playerInvolvedInSport = new PlayerInvolvedInSport();
    	$form = $this->createFormBuilder($playerInvolvedInSport)
        	->add('playerId',IntegerType::class)
		 	->add('sportId',IntegerType::class)            
			->add('startedDate',DateType::class)
           // ->add('endDate',DateType::class)
            ->add('position',TextType::class)	
            ->add('save', SubmitType::class, array('label' => 'Involve Player'))
            ->getForm();

         $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ... perform some action, such as saving the task to the database
            $playerInvolvedInSport->save();

            return $this->redirectToRoute('task_success');
        }

        // replace this example code with whatever you need
        return $this->render('playerInvolvedInSport/create.html.twig', array('form' => $form->createView()));	
    }

    /**
     * @Route("/playerInvolvedInSport/view/{id}", name="playerInvolvedInSport_view")
     */
    public function viewAction($id, Request $request)
    {
        $playerInvolvedInSport =  PlayerInvolvedInSport::getOne($id);
        return $this->render('playerInvolvedInSport/view.html.twig', array('playerInvolvedInSport' =>$playerInvolvedInSport));  
    }

    /**
     * @Route("/playerInvolvedInSport/view", name="playerInvolvedInSport_viewAll")
     */
    public function viewallAction( Request $request)
    {
        
    $playerInvolvedInSports = PlayerInvolvedInSport::getAll();
    return $this->render('playerInvolvedInSport/viewall.html.twig', array('playerInvolvedInSport' => $playerInvolvedInSports));
    }

}