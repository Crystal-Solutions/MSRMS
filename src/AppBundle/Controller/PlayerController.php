<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Player;    
use AppBundle\Entity\Department;    
use AppBundle\Entity\PlayerInvolvedInSport;    
use AppBundle\Entity\Achievement;    
use AppBundle\Entity\Sport;


use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormError;

class PlayerController extends Controller
{
    /**
     * @Route("/player/", name="player_home")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->redirectToRoute('player_viewAll');
    }


    /**
     * @Route("/player/create", name="player_create")
     */
    public function createAction(Request $request)
    {

        $player = new Player(); 

        $departments =  Department::getAll();
        $departmentIds = array();
        foreach ($departments as $d) {
            $departmentIds[$d->getName()] = $d->getId();
        }


        $form = $this->createFormBuilder($player)
            ->add('indexNumber',TextType::class)
            ->add('name', TextType::class)
            ->add('dateOfBirth', DateType::class, array(
                    'years' => range(date('Y') - 100, date('Y') - 20)
                   ))
            ->add('year',TextType::class)

            ->add('departmentId',ChoiceType::class, array(
            'choices'  => $departmentIds,
            'label'=>'Department',
                ))

            ->add('address',TextType::class)
            ->add('bloodType',ChoiceType::class, array(
                'choices'=>array('A+'=>'A+','A-'=>'A-','B+'=>'B+','B-'=>'B-','AB+'=>'AB+','AB-'=>'AB-','O+'=>'O+','O-'=>'O-')
                ))
            ->add('save', SubmitType::class, array('label' => 'Create Player'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() &&  $player->validate()) {
            // ... perform some action, such as saving the task to the database

            $player->save();

            return $this->redirectToRoute('player_viewAll');
        }

        // replace this example code with whatever you need
        return $this->render('player/create.html.twig', array('form' => $form->createView(), 'form_error'=>$player->getError()));
    }

    /**
     * @Route("/player/view/{id}/update", name="player_update")
     */
    public function updateAction($id,Request $request)
    {

        $player = Player::getOne($id); 

        $departments =  Department::getAll();
        $departmentIds = array();
        foreach ($departments as $d) {
            $departmentIds[$d->getName()] = $d->getId();
        }

        


        $form = $this->createFormBuilder($player)
            ->add('indexNumber',TextType::class)
            ->add('name', TextType::class)
            ->add('dateOfBirth', DateType::class, array(
                    'years' => range(date('Y') - 100, date('Y') - 20)
                   ))
            ->add('year',TextType::class)

            ->add('departmentId',ChoiceType::class, array(
            'choices'  => $departmentIds,
            'label'=>'Department',
                ))

            ->add('address',TextType::class)
            ->add('bloodType',ChoiceType::class, array(
                'choices'=>array('A+'=>'A+','A-'=>'A-','B+'=>'B+','B-'=>'B-','AB+'=>'AB+','AB-'=>'AB-','O+'=>'O+','O-'=>'O-')
                ))
            ->add('save', SubmitType::class, array('label' => 'Update Player'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() &&  $player->validate()) {
            // ... perform some action, such as saving the task to the database

            $player->save();

            return $this->redirectToRoute('player_viewall');
        }

        // replace this example code with whatever you need
        return $this->render('player/update.html.twig', array('form' => $form->createView(), 'form_error'=>$player->getError()));
    }

    /**
     * @Route("/player/view/{id}", name="player_view")
     */
    public function viewAction($id, Request $request)
    {
        $player =  Player::getOne($id);
        $playerInvolvedInSport = PlayerInvolvedInSport::getOne($id);


        $sports= PlayerInvolvedInSport::getInvolvedSports($playerInvolvedInSport->id);

        $playerAchievements = Achievement::getPlayerAchievements($playerInvolvedInSport->id);
        return $this->render('player/view.html.twig', array('player' =>$player, 'achievements'=>$playerAchievements,'sports'=>$sports));  

    }

    /**
     * @Route("/player/view", name="player_viewAll")
     */
    public function viewallAction( Request $request)
    {
        //$player =  Player::getOne($id);
        //return $this->render('player/view.html.twig', array('player' =>$player));

        $players =  Player::getAll();
        return $this->render('player/viewall.html.twig', array('players' => $players));

    }

 
}



