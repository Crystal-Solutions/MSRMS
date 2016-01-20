<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Equipment;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EquipmentController extends Controller
{
    /**
     * @Route("/equipment/", name="equipment_home")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->redirectToRoute('equipment_viewall');

        /*return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));*/
    }

    /**
     * @Route("/equipment/create", name="equipment_create")
     */
    public function createAction(Request $request)
    {

        $equipment = new Equipment(); 

        $form = $this->createFormBuilder($equipment)
            ->add('name', TextType::class)
            ->add('description', TextType::class)
            ->add('amount',IntegerType::class)
            ->add('save', SubmitType::class, array('label' => 'Create Equipment'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ... perform some action, such as saving the task to the database
            $equipment->save();

            return $this->redirectToRoute('equipment_viewall');
        }

        // replace this example code with whatever you need
        return $this->render('equipment/create.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/equipment/view/{id}", name="equipment_view")
     */
    public function viewAction($id, Request $request)
    {
        $equipment =  Equipment::getOne($id);
        return $this->render('equipment/view.html.twig', array('equipment' =>$equipment));  
    }

    /**
     * @Route("/equipment/view", name="equipment_viewall")
     */
    public function viewallAction( Request $request)
    {
       
       	$equipments =  Equipment::getAll();
        return $this->render('equipment/viewall.html.twig', array('equipments' => $equipments));

    }

    /**
     * @Route("/equipment/update/{id}", name="equipment_update")
     */
    public function updateAction( $id,Request $request)
    {
       
        $equipment = Equipment::getOne($id); 

        $form = $this->createFormBuilder($equipment)
            ->add('name', TextType::class)
            ->add('description', TextType::class)
            ->add('amount',IntegerType::class)
            ->add('save', SubmitType::class, array('label' => 'Update Equipment'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ... perform some action, such as saving the task to the database
            $equipment->save();

            return $this->redirectToRoute('equipment_viewall');
        }

        // replace this example code with whatever you need
        return $this->render('equipment/create.html.twig', array('form' => $form->createView()));

    }

 
}
