<?php
// under Construction
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\PlayerInvolvedInSport;
use AppBundle\Entity\Player;    
use AppBundle\Entity\Sport;
  

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;



class InvolveController extends Controller
{
    /**
     * @Route("/involve/", name="involve_home")
     */
    public function indexAction(Request $request)
    {
        $playerInvolvedInSport = new PlayerInvolvedInSport(); 

        //Generate required data for the form ----------------------- For choices
        $players =  Player::getAll();
        $playerIds = array();
        foreach ($players as $player) {
            $playerIds[$player->getIndexNumber()] = $player->getId();
        }

        $sports =  Sport::getAll();
        $sportIds = array();
        foreach ($sports as $sport) {
            $sportIds[$sport->getName()] = $sport->getId();
        }
        //------------------------------------------------------------------------
        
        //Set the default borrowed time to current time
        $playerInvolvedInSport->setStartedDate(new \DateTime('now'));

        $form = $this->createFormBuilder($playerInvolvedInSport)
            ->add('player_id',ChoiceType::class, array(
            'choices'  => $playerIds,
            'choices_as_values' => true,
            'label'=>'Index Number of the Player'
                ))
            ->add('sport_id',ChoiceType::class, array(
            'choices'  => $sportIds,
            'choices_as_values' => true,
            'label'=>'Sport'
                ))   
            ->add('startedDate',DateType::class)
            //->add('endDate',DateType::class)
            ->add('position',TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Involve Player'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ... perform some action, such as saving the task to the database
            $playerInvolvedInSport->save();

            return $this->redirectToRoute('task_success');
        }

        // replace this example code with whatever you need
        return $this->render('usecases/involve_home.html.twig', array('form' => $form->createView()));
    }

 
}
