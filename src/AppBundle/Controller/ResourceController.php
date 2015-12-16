<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Resource;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ResourceController extends Controller{

    /**
     * @Route("/resource/", name="resource_home")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('resource/create.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }

    /**
     * @Route("/resource/create", name="resource_home")
     */
    public function createAction(Request $request)
    {
        $resource = new Resource();

        $form = $this->createFormBuilder($resource)
            ->add('name', TextType::class)
            ->add('description', TextType::class)
            ->add('instructorName', TextType::class)
            ->add('location', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Create Resource'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ... perform some action, such as saving the task to the database

            $resource->save();

            return $this->redirectToRoute('task_success');
        }

        // replace this example code with whatever you need
        return $this->render('resource/create.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/resource/view", name="resource_view")
     */
    public function viewAction(Request $request)
    {
        //give the id of the person we need to view
        $au = AuthorizingOfficer::getOne(1);

        return $this->render('authorizingOfficer/view.html.twig', array('officer' => $au));
    }

    /**
     * @Route("/resource/viewAll", name="resource_viewAll")
     */
    public function viewAction(Request $request)
    {
        $officers = AuthorizingOfficer::getAll();

        return $this->render('authorizingOfficer/viewall.html.twig', array('officers' => $officers));
    }
}