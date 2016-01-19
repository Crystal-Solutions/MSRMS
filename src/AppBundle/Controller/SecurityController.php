<?php

namespace AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\AuthorizingOfficer;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login_route")
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'security/login.html.twig',
            array(
                // last username entered by the user
                'last_username' => $lastUsername,
                'error'         => $error,
            )
        );
    }

    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction()
    {
        // this controller will not be executed,
        // as the route is handled by the Security system
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
        // this controller will not be executed,
        // as the route is handled by the Security system
    }


//    Signup

    /**
     * @Route("/signup", name="signup")
     */
    public function signupAction(Request $request)
    {

        $authorizingOfficer = new AuthorizingOfficer();

        $form = $this->createFormBuilder($authorizingOfficer)
            ->add('name', TextType::class)
            ->add('contactNu', TextType::class)
            ->add('username', TextType::class)
            ->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => array('attr' => array('class' => 'password-field')),
                'required' => true,
                'first_options'  => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat Password'),
            ))
            ->add('email', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Sign Up'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ... perform some action, such as saving the task to the database

            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($authorizingOfficer);

            //Encode the password
            $encodedPassword = password_hash($authorizingOfficer->getPassword(),PASSWORD_BCRYPT);
            $authorizingOfficer->setPassword($encodedPassword);

            $authorizingOfficer->setIsActive(true);
            $authorizingOfficer->save();


            return $this->redirectToRoute('task_success');
        }


        $error = ""; //Set a valid error

        // replace this example code with whatever you need
        return $this->render('security/signup.html.twig', array('form' => $form->createView(),'error'         => $error,));
    }
}