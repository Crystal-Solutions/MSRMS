<?php

namespace AppBundle\Controller;

use AppBundle\Entity\TimeSlotResource;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\SportHasResource;
use AppBundle\Entity\Sport;    
use AppBundle\Entity\Resource;
use AppBundle\Entity\AuthorizingOfficer;      

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class AllocateController extends Controller
{
    /**
     * @Route("/allocate/resource/", name="allocate_resource")
     */
    public function allocateResourceAction(Request $request)
    {
        $sportHasResource = new SportHasResource(); 

        //Generate required data for the form ----------------------- For choices
        $sports =  Sport::getAll();
        $sportIds = array();

        // not sure about this line
        foreach ($sports as $sport) {
            $sportIds[$sport->getName()] = $sport->getId();
        }

        $resources =  Resource::getAll();
        $resourceIds = array();
        foreach ($resources as $resource) {
            $resourceIds[$resource->getName()] = $resource->getId();
        }


        $authorizingOfficers = AuthorizingOfficer::getAll();
        $authorizingOfficerIds = array();

        foreach ($authorizingOfficers as $authorizingOfficer){
            $authorizingOfficerIds[$authorizingOfficer->getName()]= $authorizingOfficer->getId();
        }
        //------------------------------------------------------------------------


//      set current user as auth


        //Set the default borrowed time to current time
        // $sportHasResource->setBorrowedTime(new \DateTime('now'));

        $form = $this->createFormBuilder($sportHasResource)
            ->add('sport_id',ChoiceType::class, array(
            'choices'  => $sportIds,
            'choices_as_values' => true,
            'label'=>'Sport'
                ))
            ->add('resource_id',ChoiceType::class, array(
            'choices'  => $resourceIds,
            'choices_as_values' => true,
            'label'=>'Resource'
                ))

//            Auth officer will be added as current user
//            ->add('authorizing_officer_id',ChoiceType::class, array(
//            'choices'  => $authorizingOfficerIds,
//            'choices_as_values' => true,
//            'label'=>'Authorizing Officer'
//                ))

            ->add('save', SubmitType::class, array('label' => 'Allocate Resource'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //Set current user as auth officer
            $sportHasResource->setAuthorizingOfficerId($this->getUser()->getId());

            // ... perform some action, such as saving the task to the database
            $sportHasResource->save();

            return $this->redirectToRoute('sportHasResource_viewAll');
        }

        // replace this example code with whatever you need
        return $this->render('usecases/allocate_home.html.twig', array('form' => $form->createView()));
    }



//    Time Slot
    /**
     * @Route("/allocate/resource/addtimeslot/{id}", name="allocate_resource_addtimeslot")
     */
    public function addTimeSlotResource($id, Request $request)
    {
        $sportHasResource = SportHasResource::getOne($id);

        $sport = Sport::getOne($sportHasResource->getSportId());
        $resource = Resource::getOne($sportHasResource->getResourceId());

        $timeSlot = new TimeSlotResource();

        $form = $this->createFormBuilder($timeSlot)
            ->add('startTime',TimeType::class ,
                array('input'  => 'string'))
            ->add('endTime',TimeType::class, array('input'  => 'string'))
            ->add('day',ChoiceType::class, array(
                'choices'=>array('Sunday'=>'Sunday',
                    'Monday'=>'Monday',
                    'Tuesday'=>'Tuesday',
                    'Wednesday'=>'Wednesday',
                    'Thursday'=>'Thursday',
                    'Friday'=>'Friday',
                    'Saturday'=>'Saturday')
            ))
            ->add('save', SubmitType::class, array('label' => 'Add Time Slot'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $timeSlot->validate()) {
            // ... perform some action, such as saving the task to the database

            $timeSlot->setSportHasResourceId($id);
            $timeSlot->save();

            return $this->redirectToRoute('sportHasResource_view',array('id'=>$id));
        }

        // replace this example code with whatever you need
        return $this->render('sportHasResource/create.html.twig', array('form' => $form->createView(),'sport'=> $sport->getName(), 'resource'=> $resource->getName(), 'error'=>$timeSlot->errorMessage ));
    }

    
 
}
