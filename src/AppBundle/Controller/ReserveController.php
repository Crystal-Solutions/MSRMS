<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\EquipmentReservedByPlayer;
use AppBundle\Entity\Player;    
use AppBundle\Entity\Equipment;
use AppBundle\Entity\AuthorizingOfficer;
  

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;



class ReserveController extends Controller
{
    /**
     * @Route("/reserve/", name="reserve_home")
     */
    public function indexAction(Request $request)
    {
        //return $this->redirectToRoute('reservation_viewall');
        $equipmentReservedByPlayer = new EquipmentReservedByPlayer(); 

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

        $authOfficers =  AuthorizingOfficer::getAll();
        $authIds = array();
        foreach ($authOfficers as $au) {
            $authIds[$au->getName()] = $au->getId();
        }

        //------------------------------------------------------------------------
        
        //Set the default reserved time to current time
        $equipmentReservedByPlayer->SetStart(new \DateTime('now'));
        $equipmentReservedByPlayer->SetEnd(new \DateTime('now'));

        $form = $this->createFormBuilder($equipmentReservedByPlayer)
            ->add('equipment_id',ChoiceType::class, array(
            'choices'  => $equipmentIds,
            'choices_as_values' => true,
            'label'=>'Equipment'
                ))

            ->add('player_id',ChoiceType::class, array(
            'choices'  => $playerIds,
            'choices_as_values' => true,
            'label'=>'Index Number of the Player'
                ))

            ->add('start',DateTimeType::class)
            ->add('end',DateTimeType::class)
            ->add('amount',IntegerType::class,array('attr'=>(array('min'=>1))))

            ->add('authorizing_officer_id',ChoiceType::class, array(
            'choices'  => $authIds,
            'choices_as_values' => true,
            'label'=>'Authorizing Officer'
                ))

            ->add('save', SubmitType::class, array('label' => 'Reserve Equipment'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $equipmentReservedByPlayer->validate()) {
            // ... perform some action, such as saving the task to the database
            $equipmentReservedByPlayer->save();

            return $this->redirectToRoute('reservation_viewall');
        }

        // replace this example code with whatever you need
        //return $this->render('usecases/reserve_home.html.twig', array('form' => $form->createView()));
        return $this->render('usecases/reserve_home.html.twig', array('form' => $form->createView(), 'form_error'=>$equipmentReservedByPlayer->getError()));
    }

 
}
