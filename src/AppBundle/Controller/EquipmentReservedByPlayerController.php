<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\EquipmentReservedByPlayer;
use AppBundle\Entity\Player;


use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EquipmentReservedByPlayerController extends Controller
{
    /**
     * @Route("/EquipmentReservedByPlayer/", name="reservation_home")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->redirectToRoute('reservation_viewall');
       /* return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));*/
    }


    /**
     * @Route("/equipmentreservedbyplayer/create", name="reservation_create")
     */
    public function createAction(Request $request)
    {

        $equipmentReservedByPlayer = new EquipmentReservedByPlayer(); 

        $form = $this->createFormBuilder($equipmentReservedByPlayer)
            ->add('equipment_id', IntegerType::class)
            ->add('player_id', IntegerType::class)
            ->add('start', DateTimeType::class)
            ->add('end', DateTimeType::class)
            ->add('amount', IntegerType::class)
            ->add('authorizing_officer_id', IntegerType::class)
            ->add('save', SubmitType::class, array('label' => 'Reserve the Equipment'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ... perform some action, such as saving the task to the database

            $equipmentReservedByPlayer->save();
            
            return $this->redirectToRoute('task_success');
        }


        // replace this example code with whatever you need
        return $this->render('equipmentReservedByPlayer/create.html.twig', array('form' => $form->createView(),'form_error'=>$equipmentReservedByPlayer->getError()));
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
