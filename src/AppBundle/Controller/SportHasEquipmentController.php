<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\SportHasEquipment;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;



class SportHasEquipmentController extends Controller
{
    /**
     * @Route("/sportHasEquipment/", name="sportHasEquipment_home")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->redirectToRoute('sportHasEquipment_viewAll');
    }


    /**
     * @Route("/sportHasEquipment/create", name="sportHasEquipment_create")
     */
    public function createAction(Request $request)
    {

        $sportHasEquipment = new SportHasEquipment(); 

        $form = $this->createFormBuilder($sportHasEquipment)
            ->add('sport_id',IntegerType::class)
		 	->add('resource_id',IntegerType::class)            
			->add('authorizing_officer_id',IntegerType::class)
            ->add('save', SubmitType::class, array('label' => 'Allocate Resource'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ... perform some action, such as saving the task to the database
            $sportHasEquipment->save();

            return $this->redirectToRoute('task_success');
        }

        // replace this example code with whatever you need
        return $this->render('sportHasEquipment/create.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/sportHasEquipment/view/{id}", name="sportHasEquipment_view")
     */
    public function viewAction($id, Request $request)
    {
        $sportHasEquipment =  SportHasEquipment::getOne($id);
        return $this->render('sportHasEquipment/view.html.twig', array('sportHasEquipment' =>$sportHasEquipment));  
    }

    /**
     * @Route("/sportHasEquipment/view", name="sportHasEquipment_viewAll")
     */
    public function viewallAction( Request $request)
    {
        

    $sportHasEquips = SportHasEquipment::getAll();
    return $this->render('sportHasEquipment/viewall.html.twig', array('sportHasEquips' => $sportHasEquips));

    }

 
}
