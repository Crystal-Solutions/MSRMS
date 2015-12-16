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
        return $this->redirectToRoute('resource_viewAll');
    }

    /**
     * @Route("/resource/create", name="resource_create")
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
     * @Route("/resource/view/{id}", name="resource_view")
     */
    public function viewAction($id,Request $request)
    {
        //give the id of the person we need to view
        $res = Resource::getOne($id);

        return $this->render('resource/view.html.twig', array('resource' => $res));
    }

    /**
     * @Route("/resource/view", name="resource_viewAll")
     */
    public function viewAllAction(Request $request)
    {
        $rss = Resource::getAll();

        return $this->render('resource/viewall.html.twig', array('resources' => $rss));
    }
}