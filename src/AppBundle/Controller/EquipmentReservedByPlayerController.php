<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Department;


use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DepartmentController extends Controller
{
    /**
     * @Route("/EquipmentReservedByPlayer/", name="EquipmentReservedByPlaye_home")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }


    /**
     * @Route("/equipmentreservedbyplayer/create", name="department_create")
     */
    public function createAction(Request $request)
    {

        $equipmentReservedByPlayer = new EquipmentReservedByPlayer(); 

        $form = $this->createFormBuilder($equipmentReservedByPlayer)
            ->add('equipment_id', TextType::class)
            ->add('player_id', TextType::class)
            ->add('start', DateTimeType::class)
            ->add('end', DateTimeType::class)
            ->add('amount', DateTimeType::class)
            ->add('end', DateTimeType::class)
            ->add('save', SubmitType::class, array('label' => 'Reserve the Equipment'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ... perform some action, such as saving the task to the database

            $equipmentReservedByPlayer->save();
            
            return $this->redirectToRoute('task_success');
        }


        // replace this example code with whatever you need
        return $this->render('equipmentReservedByPlayer/create.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/equipmentreservedbyplayer/view/{id}", name="department_view")
     */
    public function viewAction($id, Request $request)
    {
        $equip = EquipmentReservedByPlayer::getOne($id);
        return $this->render('equipmentReservedByPlayer/view.html.twig', array('equip' => $equip));
    }

    /**
     * @Route("/equipmentreservedbyplayer/view", name="department_viewall")
     */
    public function viewallAction(Request $request)
    {
        $equips = EquipmentReservedByPlayer::getAll();
        return $this->render('equipmentReservedByPlayer/viewall.html.twig', array('equips' => $equips));
    }
}
