<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\EquipmentReservedByPlayer;


use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EquipmentReservedByPlayerController extends Controller
{
    /**
     * @Route("/EquipmentReservedByPlayer/", name="EquipmentReservedByPlayer_home")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }


    /**
     * @Route("/equipmentreservedbyplayer/create", name="reservation_create")
     */
    public function createAction(Request $request)
    {

        $equipmentReservedByPlayer = new EquipmentReservedByPlayer(); 

        $form = $this->createFormBuilder($equipmentReservedByPlayer)
            ->add('equipment_id', TextType::class)
            ->add('player_id', TextType::class)
            ->add('start', TextType::class)
            ->add('end', TextType::class)
            ->add('amount', TextType::class)
            ->add('authorizing_officer_id', TextType::class)
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
     * @Route("/equipmentreservedbyplayer/view/{id}", name="reservation_view")
     */
    public function viewAction($id, Request $request)
    {
        $equip = EquipmentReservedByPlayer::getOne($id);
        return $this->render('equipmentReservedByPlayer/view.html.twig', array('equip' => $equip));
    }

    /**
     * @Route("/equipmentreservedbyplayer/view", name="reservation_viewall")
     */
    public function viewallAction(Request $request)
    {
        $equips = EquipmentReservedByPlayer::getAll();
        return $this->render('equipmentReservedByPlayer/viewall.html.twig', array('equips' => $equips));
    }
}
