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
     * @Route("/department/", name="department_home")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }


    /**
     * @Route("/department/create", name="department_create")
     */
    public function createAction(Request $request)
    {

        $department = new Department(); 




        $form = $this->createFormBuilder($department)
            ->add('name', TextType::class)
            ->add('faculty_id', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Create Department'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ... perform some action, such as saving the task to the database

            $department->save();
            /*$em = $this->getDoctrine()->getManager();

            $em->persist($department);
            $em->flush();*/

            return $this->redirectToRoute('task_success');
        }


        // replace this example code with whatever you need
        return $this->render('department/create.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/department/view/{id}", name="department_view")
     */
    public function viewAction($id, Request $request)
    {
        $dept = Department::getOne($id);
        return $this->render('department/view.html.twig', array('dept' => $dept));
    }

    /**
     * @Route("/department/view", name="department_viewall")
     */
    public function viewallAction(Request $request)
    {
        $depts = Department::getAll();
        return $this->render('department/viewall.html.twig', array('depts' => $depts));
    }
}
