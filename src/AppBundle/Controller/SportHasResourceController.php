<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\SportHasResource;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;



class SportHasResourceController extends Controller
{
    /**
     * @Route("/sportHasResource/", name="sportHasResource_home")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->redirectToRoute('sportHasResource_viewAll');
    }


    /**
     * @Route("/sportHasResource/create", name="sportHasResource_create")
     */
    public function createAction(Request $request)
    {

        $sportHasResource = new SportHasResource(); 

        $form = $this->createFormBuilder($sportHasResource)
            ->add('sport_id',IntegerType::class)
		 	->add('resource_id',IntegerType::class)            
			->add('authorizing_officer_id',IntegerType::class)
            ->add('save', SubmitType::class, array('label' => 'Allocate Resource'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ... perform some action, such as saving the task to the database
            $sportHasResource->save();

            return $this->redirectToRoute('task_success');
        }

        // replace this example code with whatever you need
        return $this->render('sportHasResource/create.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/sportHasResource/view/{id}", name="sportHasResource_view")
     */
    public function viewAction($id, Request $request)
    {
        $sportHasResource =  SportHasResource::getOne($id);
        return $this->render('sportHasResource/view.html.twig', array('sportHasResource' =>$sportHasResource));  
    }

    /**
     * @Route("/sportHasResource/view", name="sportHasResource_viewAll")
     */
    public function viewallAction( Request $request)
    {
        

    $sportHasResources = SportHasResource::getAll();
    return $this->render('sportHasResource/viewall.html.twig', array('sportHasResources' => $sportHasResources));

    }

    /**
     * @Route("/sportHasResource/delete/{id}", name="sportHasResource_delete")
     */
    public function deleteAction($id, Request $request)
    {
        SportHasResource::delete($id);
        return $this->redirectToRoute('sportHasResource_viewAll');

    }
    
 
}
