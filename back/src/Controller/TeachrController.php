<?php

namespace App\Controller;
use App\Entity\Teachr;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\TeachrFormType;

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

private function serializeProgrammer(Teachr $teachr)
{
    return array(
        'firstname' => $teachr->getFirstname(),
        'date' => $teachr->getDate(),
        
    );
}

 /**
     * @Route("/api/public", name="public")
     * @return JsonResponse
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
        $data = array('teachers' => array());
        foreach ($teachers as $teachr) {
            $data['teachers'][] = $this->serializeProgrammer($teachr);
        }
        $response = new Response(json_encode($data), 200);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
       // return $response;
        

        //return new JsonResponse($teachers);
    }


}
