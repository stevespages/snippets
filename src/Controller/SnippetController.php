<?php

namespace App\Controller;

//namespace Acme\TaskBundle\Controller;// ??


use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Snippet;

class SnippetController extends Controller
{
    /**
     * @Route("/snippet", name="snippet")
     */
    //public function index()
	 public function new(Request $request)
    {
    	

		  // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to your action: index(EntityManagerInterface $em)
        //$em = $this->getDoctrine()->getManager();

        $snippet = new Snippet();
        //$snippet->setSnip('ls');
        //$snippet->setDescription('lists files');
        //$snippet->setLanguage('Bash');

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        //$em->persist($snippet);

        // actually executes the queries (i.e. the INSERT query)
        //$em->flush();
        
        
		  $form = $this->createFormBuilder($snippet)
            ->add('snip', TextType::class)
            ->add('description', TextType::class)
            ->add('language', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Snip'))
            ->getForm();
            
        $form->handleRequest($request);

    	  if ($form->isSubmitted() && $form->isValid()) {
        		// $form->getData() holds the submitted values
        		// but, the original `$task` variable has also been updated
        		$snippet = $form->getData();

        		// if submission is a new snippet:
        		$em = $this->getDoctrine()->getManager();
        		$em->persist($snippet);
        		$em->flush();

        //return $this->redirectToRoute('snippet');
        
        //$request->query->get()
        
        
    }
    
		  $a = $request->query->get('action');    
    
    	  $repository = $this->getDoctrine()->getRepository(Snippet::class);
    	  $snippets = $repository->findAll();
    	  
    	  dump($a);
            
		  return $this->render('default/new.html.twig', array(
            'form' => $form->createView(), 'snippets' => $snippets,
        ));
        
        
    }
}
