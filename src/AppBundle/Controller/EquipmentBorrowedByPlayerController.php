<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\EquipmentBorrowedByPlayer;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;



class EquipmentBorrowedByPlayerController extends Controller
{
    /**
     * @Route("/equipmentBorrowedByPlayer/", name="equipmentBorrowedByPlayer_home")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->redirectToRoute('equipmentBorrowedByPlayer_viewAll');
    }


    /**
     * @Route("/equipmentBorrowedByPlayer/create", name="equipmentBorrowedByPlayer_create")
     */
    public function createAction(Request $request)
    {

        $equipmentBorrowedByPlayer = new EquipmentBorrowedByPlayer(); 

        $form = $this->createFormBuilder($equipmentBorrowedByPlayer)
            ->add('player_id',IntegerType::class)
		 	->add('equipment_id',IntegerType::class)            
			->add('amount',IntegerType::class)
            ->add('borrowedTime',DateTimeType::class)
            ->add('dueTime',DateTimeType::class)
            ->add('returnedTime',DateTimeType::class)
            ->add('issueDetails',TextType::class)  
            ->add('save', SubmitType::class, array('label' => 'Reserve Equipment'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ... perform some action, such as saving the task to the database
            $equipmentBorrowedByPlayer->save();

            return $this->redirectToRoute('task_success');
        }

        // replace this example code with whatever you need
        return $this->render('equipmentBorrowedByPlayer/create.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/equipmentBorrowedByPlayer/view/{id}", name="equipmentBorrowedByPlayer_view")
     */
    public function viewAction($id, Request $request)
    {
        $equipmentBorrowedByPlayer =  EquipmentBorrowedByPlayer::getOne($id);
        return $this->render('equipmentBorrowedByPlayer/view.html.twig', array('equipmentBorrowedByPlayer' =>$equipmentBorrowedByPlayer));  
    }

    /**
     * @Route("/equipmentBorrowedByPlayer/view", name="equipmentBorrowedByPlayer_viewAll")
     */
    public function viewallAction( Request $request)
    {
        

    $equipmentBorrowedByPlayers = EquipmentBorrowedByPlayer::getAll();
    return $this->render('equipmentBorrowedByPlayer/viewall.html.twig', array('equipmentBorrowedByPlayer' => $equipmentBorrowedByPlayers));

    }

     /**
     * @Route("/equipmentBorrowedByPlayer/delete/{id}", name="equipmentBorrowedByPlayer_delete")
     */
    public function deleteAction($id, Request $request)
    {
        EquipmentBorrowedByPlayer::delete($id);
        return $this->redirectToRoute('equipmentBorrowedByPlayer_viewAll');

    }


    /**
     * @Route("/equipmentBorrowedByPlayer/return/{id}", name="equipmentBorrowedByPlayer_return")
     */
    public function returnAction($id, Request $request)
    {
        $equipmentBorrowedByPlayer = EquipmentBorrowedByPlayer::getOne($id); 
        $equipmentBorrowedByPlayer->setBorrowedTime(new \DateTime($equipmentBorrowedByPlayer->getBorrowedTime()));
        $equipmentBorrowedByPlayer->setDueTime(new \DateTime($equipmentBorrowedByPlayer->getDueTime()));
        $equipmentBorrowedByPlayer->setReturnedTime(new \DateTime('now'));
        $equipmentBorrowedByPlayer->save();
        return $this->redirectToRoute('equipmentBorrowedByPlayer_viewAll');

    }

}
