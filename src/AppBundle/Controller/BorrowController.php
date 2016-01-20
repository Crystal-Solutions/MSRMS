<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\EquipmentBorrowedByPlayer;
use AppBundle\Entity\Player;    
use AppBundle\Entity\Equipment;
  

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;



class BorrowController extends Controller
{
    /**
     * @Route("/borrow/", name="borrow_home")
     */
    public function borrowAction(Request $request)
    {
        $equipmentBorrowedByPlayer = new EquipmentBorrowedByPlayer(); 

        //Generate required data for the form ----------------------- For choices
        $players =  Player::getAll();
        $playerIds = array();
        foreach ($players as $player) {
            $playerIds[$player->getIndexNumber()] = $player->getId(); 
        }

        $equipments =  Equipment::getAll();
        $equipmentIds = array();
        foreach ($equipments as $eq) {
            $equipmentIds[$eq->getName()] = $eq->getId();
        }

        //------------------------------------------------------------------------
        
        //Set the default borrowed time to current time
        $equipmentBorrowedByPlayer->setBorrowedTime(new \DateTime('now'));
        $equipmentBorrowedByPlayer->setDueTime(new \DateTime('now'));

        $form = $this->createFormBuilder($equipmentBorrowedByPlayer)
            ->add('player_id',ChoiceType::class, array(
            'choices'  => $playerIds,
            'choices_as_values' => true,
            'label'=>'Index Number of the Player'
                ))
            ->add('equipment_id',ChoiceType::class, array(
            'choices'  => $equipmentIds,
            'choices_as_values' => true,
            'label'=>'Equipment'
                ))   

            ->add('amount',IntegerType::class,array('attr'=>(array('min'=>1))))
            ->add('borrowedTime',DateTimeType::class,array(
                'years'=>range(date('Y'),date('Y')),'months'=>range(date('m'),date('m')),'days'=>range(date('d')-1,date('d'))
                ))
            ->add('dueTime',DateTimeType::class,array(
                'years'=>range(date('Y'),date('Y')+2)
                ))   
            ->add('issueDetails',TextType::class)                
            ->add('save', SubmitType::class, array('label' => 'Borrow Equipment'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $equipmentBorrowedByPlayer->validate()) {

            // ... perform some action, such as saving the task to the database
            $equipmentBorrowedByPlayer->save();

            return $this->redirectToRoute('equipmentBorrowedByPlayer_viewAll');
        }

        // replace this example code with whatever you need

        //return $this->render('usecases/reserve_home.html.twig', array('form' => $form->createView()));
        return $this->render('usecases/borrow_home.html.twig', array('form' => $form->createView(), 'form_error'=>$equipmentBorrowedByPlayer->getError()));
    }
}
