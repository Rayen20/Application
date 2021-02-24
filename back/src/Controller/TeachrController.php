<?php

namespace App\Controller;
use App\Entity\Teachr;
use App\Entity\Statistics;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\TeachrFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;


// This is my teachr controller , I did an  api rest  with (GET, POST, PUT) , 
//also as a bonus I made some simple interfaces in which you can insert, modify or view the data through the browser  
//you will find an explanation in front of each function 
class TeachrController extends AbstractController
{  
    

// API (GET,PUT,POST)

// api : POST &&  counter increment that is in the statistic table 


/**
     * @Route("/api/post", name="post",methods={"POST"})
     * 
     *
     */
public function postAction(Request $request){
   

    // initialize the counter to 0 
        $n = 0;
        
    // get all objects teachers  
        $teachers = $this->getDoctrine()
        ->getRepository(Teachr::class)
        ->findAll();


    // from  table statistic we fixed the object with id= 1 as an counter 
    //and each time a teach object is inserted, the counter increments with 1 
        
        $entityManag = $this->getDoctrine()->getManager();
        $stats = $entityManag->getRepository(Statistics::class)
        ->find(1);


        foreach ($teachers as $teach) {

            $n ++ ;
       
        if ($stats) {
        
        $stats->setCount($n +1);

        $entityManag->flush(); 
    
    }
       
       
        }

    
        // new teachr
        $teachr = new Teachr();

       
        // decoding data
        $donnees = json_decode($request->getContent());
     
        // insertion
        $teachr->setFirstname($donnees->firstname);
        $teachr->setDate(new \DateTime('now'));
        // persist into the database
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($teachr);
        
      
        $entityManager->flush();

     
    return new Response();


   
    }


// Api : PUT

/**
 * @Route("/api/put/{id}", name="put", methods={"PUT"})
 */
public function put(?Teachr $teachr,Request $request)
{
    


     // decoding data
    $donnees = json_decode($request->getContent());

    // We initialize the response code 
    $code = 200;

// If the teachr is not found 
   if(!$teachr){
        // We instantiate a new  teachr object 
        $teachr = new Teachr();
        // We change the response code 
        $code = 201;
    }

    // set
    $teachr->setFirstname($donnees->firstname);
    $teachr->setDate(new \DateTime('now'));

    //  persist into the database
    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->persist($teachr);
    $entityManager->flush();

    // We return the confirmation 
  
return new Response('status', $code);
}

 // function to serialize the object that will be used in the get API 

private function serializeProgrammer(Teachr $teachr)
{
    return array(
        'firstname' => $teachr->getFirstname(),
        'date' => $teachr->getDate(),
        
    );
}

// API : GET

 /**
     * @Route("/api/get", name="get")
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getAction()
    {
        // find all teachers 
        $teachers = $this->getDoctrine()
            ->getRepository(Teachr::class)
            ->findAll();

            // data extractions 
        $data = array();
        foreach ($teachers as $teachr) {
            $data[] = $this->serializeProgrammer($teachr);
        }
        
        $response = new Response();

        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        // decoding data

        $response->setContent(json_encode($data));
        
        return $response;
       
    }
    
   
    
// Statistics







// this part contains interfaces that will be displayed in the browser  (GET , PUT , POST)


// this is a simple interface for adding new teachr object

    /**
 * @Route("/add", name="add")
 */
public function add(Request $request): Response
{
    $teachr = new Teachr();
    $form = $this->createForm(TeachrFormType::class, $teachr);
    $teachr->setDate(new \DateTime('now'));
    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid())
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($teachr);
        $entityManager->flush();
    }

    return $this->render("teachr/teachr-form.html.twig", [
        "form_title" => "Ajouter un objet teachr",
        "form_teachr" => $form->createView(),
    ]);
}
// A simple interface that display all objects on browser
     
/**
 * @Route("/teachers", name="teachers")
 */
public function teachers()
{
    $teachers = $this->getDoctrine()->getRepository(Teachr::class)->findAll();

    return $this->render('teachr/teachers.html.twig', [
        "teachers" => $teachers,
    ]);
}

// A simple interface in which  we can  update data
/**
 * @Route("/update/{id}", name="update")
 */
public function update(Request $request, int $id): Response
{
    $entityManager = $this->getDoctrine()->getManager();

    $teachr = $entityManager->getRepository(Teachr::class)->find($id);
    $form = $this->createForm(TeachrFormType::class, $teachr);
    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid())
    {
        $entityManager->flush();
    }

    return $this->render("teachr/teachr-form.html.twig", [
        "form_title" => "Modifier un objet teachr",
        "form_teachr" => $form->createView(),
    ]);


}

}
