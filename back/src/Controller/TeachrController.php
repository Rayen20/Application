<?php

namespace App\Controller;
use App\Entity\Teachr;
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

class TeachrController extends AbstractController
{  
    /**
     * @Route("/teachr", name="teachr")
     */
    public function index(): Response
    {
        return $this->render('teachr/index.html.twig', [
            'controller_name' => 'TeachrController',
        ]);
    }

    /**
 * @Route("/add", name="add")
 */
public function add(Request $request): Response
{
    $teachr = new Teachr();
    $form = $this->createForm(TeachrFormType::class, $teachr);
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


/**
     * @Route("/api/post", name="post",methods={"POST"})
     * 
     *
     */
public function postAction(Request$request){
    
   // if($request->isXmlHttpRequest()) {
        // On instancie un nouvel article
        $article = new Teachr();

        // On décode les données envoyées
        $donnees = json_decode($request->getContent());

        // On hydrate l'objet
        $article->setFirstname($donnees->firstname);
        $article->setDate(new \DateTime('now'));
       
        

        // On sauvegarde en base
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($article);
        $entityManager->flush();

        // On retourne la confirmation
     //   return new Response('ok', 201);
   // }
    return new Response();


    /*$data=json_decode($request->getContent(),true);
    $form->submit($data);
    if($form->isSubmitted()&&$form->isValid())
    {$em=$this->getDoctrine()->getManager()
        ;$em->persist($teachr);
        $em->flush();
        return$this->handleView($this->view(['status'=>'ok'],Response::HTTP_CREATED));}*/
       // return$this->handleView($this->view($form->getErrors()));
    }
    
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



/**
 * @Route("/put/{id}", name="put")
 */
public function put(Request $request, int $id): Response
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
/**
     * @Route("/api/users", name="users")
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getUsers()
    {
        $users = [
            [
                'title' => 'Beautiful and dramatic Antelope Canyon',
                'subtitle'=> 'Lorem ipsum dolor sit amet et nuncat mergitur',
                'illustration'=>'https://i.imgur.com/UYiroysl.jpg'
            ],
            [
                'title' => 'Beautiful and dramatic Antelope Canyon',
                'subtitle'=> 'Lorem ipsum dolor sit amet et nuncat mergitur',
                'illustration'=>'https://i.imgur.com/UYiroysl.jpg'
              ],
            [
                'title' => 'Beautiful and dramatic Antelope Canyon',
                'subtitle'=> 'Lorem ipsum dolor sit amet et nuncat mergitur',
                'illustration'=>'https://i.imgur.com/UYiroysl.jpg'
             ]
        ];
    
        $response = new Response();

        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        $response->setContent(json_encode($users));
        
        return $response;
    }
private function serializeProgrammer(Teachr $teachr)
{
    return array(
        'firstname' => $teachr->getFirstname(),
        'date' => $teachr->getDate(),
        
    );
}

 /**
     * @Route("/api/public", name="public")
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function publicAction()
    {
        //$teachers = $this->getDoctrine()->getRepository(Teachr::class)->findAll();
       // $response = new Response();

        /*$response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        $response->setContent(json_encode($teachers));*/
        
        $teachers = $this->getDoctrine()
            ->getRepository(Teachr::class)
            ->findAll();
        $data = array();
        foreach ($teachers as $teachr) {
            $data[] = $this->serializeProgrammer($teachr);
        }
        
        $response = new Response();

        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        $response->setContent(json_encode($data));
        
        return $response;
       // return $response;
        

        //return new JsonResponse($teachers);
    }


}
