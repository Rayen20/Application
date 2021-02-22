<?php

namespace App\Controller;
use App\Entity\Teachr;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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
}
