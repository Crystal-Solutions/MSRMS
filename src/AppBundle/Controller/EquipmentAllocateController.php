<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\SportHasEquipment;
use AppBundle\Entity\Sport;    
use AppBundle\Entity\Equipment;
use AppBundle\Entity\AuthorizingOfficer;
  

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;



class EquipmentAllocateController extends Controller
{
    /**
     * @Route("/equipmentAllocate/", name="equipment_allocate_home")
     */
    public function indexAction(Request $request)
    {
        $sportHasEquipment = new SportHasEquipment(); 

        //Generate required data for the form ----------------------- For choices
        $sports =  Sport::getAll();
        $sportIds = array();
        foreach ($sports as $sport) {
            $sportIds[$sport->getName()] = $sport->getId();
        }

        $equipments =  Equipment::getAll();
        $equipmentIds = array();
        foreach ($equipments as $eq) {
            $equipmentIds[$eq->getName()] = $eq->getId();
        }

        $authorizingOfficers = AuthorizingOfficer :: getAll();
        $authorizingOfficerIds = array();

        foreach ($authorizingOfficers as $authorizingOfficer){
            $authorizingOfficerIds[$authorizingOfficer->getName()]= $authorizingOfficer->getId();
        }
        //------------------------------------------------------------------------



        $form = $this->createFormBuilder($sportHasEquipment)
            ->add('equipment_id',ChoiceType::class, array(
            'choices'  => $equipmentIds,
            'choices_as_values' => true,
            'label'=>'Equipment'
                ))
            ->add('sport_id',ChoiceType::class, array(
            'choices'  => $sportIds,
            'choices_as_values' => true,
            'label'=>'Sport'
                ))   
            ->add('authorizing_officer_id',ChoiceType::class, array(
            'choices'  => $authorizingOfficerIds,
            'choices_as_values' => true,
            'label'=>'Authorizing Officer'
                )) 

            ->add('save', SubmitType::class, array('label' => 'Allocate Equipment'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ... perform some action, such as saving the task to the database
            $sportHasEquipment->save();

            return $this->redirectToRoute('sportHasEquipment_viewAll');
        }

        // replace this example code with whatever you need
        return $this->render('usecases/equipment_allocate_home.html.twig', array('form' => $form->createView()));
    }

 
}
