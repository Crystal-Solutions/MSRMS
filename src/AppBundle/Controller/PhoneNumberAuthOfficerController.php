<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\PhoneNumberAuthOfficer;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class PhoneNumberAuthOfficerController extends Controller
{
    /**
     * @Route("/phoneNumberAuthOfficer/", name="phoneNumberAuthOfficer_home")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->redirectToRoute('phoneNumberAuthOfficer_create');
    }

    /**
     * @Route("/phoneNumberAuthOfficer/create", name="phoneNumberAuthOfficer_create")
     */
    public function createAction(Request $request)
    {
        $phoneNumberAuthOfficer = new PhoneNumberAuthOfficer();
        $form = $this->createFormBuilder($phoneNumberAuthOfficer)
            ->add('number',IntegerType::class)
            ->add('authorizingOfficerId',IntegerType::class)            
            ->add('save', SubmitType::class, array('label' => 'Add Phone number '))
            ->getForm();

         $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ... perform some action, such as saving the task to the database
            $phoneNumberAuthOfficer->save();

            return $this->redirectToRoute('task_success');
        }

        // replace this example code with whatever you need
        return $this->render('phoneNumberAuthOfficer/create.html.twig', array('form' => $form->createView()));  
    }

    

    /**
     * @Route("/phoneNumberAuthOfficer/view/{id}", name="phoneNumberAuthOfficer_view")
     */
    public function viewAction($id, Request $request)
    {
        $phoneNumberAuthOfficer =  PhoneNumberAuthOfficer::getOne($id);
        return $this->render('phoneNumberAuthOfficer/view.html.twig', array('phoneNumberAuthOfficer ' =>$phoneNumberAuthOfficer));  
    }

    /**
     * @Route("/phoneNumberAuthOfficer/view", name="phoneNumberAuthOfficer_viewAll")
     */
    public function viewallAction( Request $request)
    {
        
    $phoneNumberAuthOfficers = PhoneNumberAuthOfficer::getAll();
    return $this->render('phoneNumberAuthOfficer/viewall.html.twig', array('phoneNumberAuthOfficer' => $phoneNumberAuthOfficers));
    }

}