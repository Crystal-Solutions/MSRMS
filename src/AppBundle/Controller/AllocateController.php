<?php
// under construction -- [IMPORTANT]
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\SportHasResource;
use AppBundle\Entity\Sport;    
use AppBundle\Entity\Resource;
use AppBundle\Entity\AuthorizingOfficer;      

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;



class AllocateController extends Controller
{
    /**
     * @Route("/allocate/", name="allocate_home")
     */
    public function indexAction(Request $request)
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


        $authorizingOfficers = AuthorizingOfficer :: getAll();
        $authorizingOfficerIds = array();

        foreach ($authorizingOfficers as $authorizingOfficer){
            $authorizingOfficerIds[$authorizingOfficer->getName()]= $authorizingOfficer->getId();
        }
        //------------------------------------------------------------------------
        
        //Set the default borrowed time to current time
      //  $sportHasResource->setBorrowedTime(new \DateTime('now'));

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
            ->add('authorizing_officer_id',ChoiceType::class, array(
            'choices'  => $authorizingOfficerIds,
            'choices_as_values' => true,
            'label'=>'Authorizing Officer'
                ))    

            ->add('save', SubmitType::class, array('label' => 'Allocate Resource'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ... perform some action, such as saving the task to the database
            $sportHasResource->save();

            return $this->redirectToRoute('task_success');
        }

        // replace this example code with whatever you need
        return $this->render('usecases/allocate_home.html.twig', array('form' => $form->createView()));
    }

 
}
