<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\StageType;
use App\Repository\StageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Stage;
use Doctrine\ORM\EntityManagerInterface;



class StageController extends AbstractController
{
    /**
     * Lister tous les stages.
     * @Route("/stage", name="stage.list")
     * @return Response
     */
    public function list(EntityManagerInterface $em) : Response
    {
        $stages = $this->getDoctrine()->getRepository(Stage::class)->getStagesNonExpires();

        return $this->render('stage/list.html.twig', [
            'stages' => $stages,
        ]);
    }

    /**
     * Chercher et aﬃcher un stage.
     * @Route("/stage/{id}", name="stage.show", requirements={"id" = "\d+"})
     * @param Stage $stage
     * @return Response
     */
    public function show(Stage $stage) : Response
    {
        return $this->render('stage/show.html.twig', [
            'stage' => $stage,
        ]);
    }

    /**
     * Créer un nouveau stage.
     * @Route("/nouveau-stage", name="stage.create")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     */
    public function create(Request $request, EntityManagerInterface $em) : Response
    {
        $stage = new Stage();
        $form = $this->createForm(StageType::class, $stage);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($stage);
            $em->flush();
            return $this->redirectToRoute('stage.list');
        }
        return $this->render('stage/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * Éditer un stage.
     * @Route("stage/{id}/edit", name="stage.edit")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     */
    public function edit(Request $request, Stage $stage, EntityManagerInterface $em) : Response
    {
        $form = $this->createForm(StageType::class, $stage);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('stage.list');
        }
        return $this->render('stage/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

/**
* Supprimer un stage.
* @Route("stage/{id}/delete", name="stage.delete")
* @param Request $request
* @param Stage $stage
* @param EntityManagerInterface $em
* @return Response
*/
    public function delete(Request $request, Stage $stage, EntityManagerInterface $em) : Response
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('stage.delete', ['id' => $stage->getId()]))
            ->getForm();
        $form->handleRequest($request);
        if ( ! $form->isSubmitted() || ! $form->isValid()) {
            return $this->render('stage/delete.html.twig', [
                'stage' => $stage,
                'form' => $form->createView(),
            ]);
        }
        $em->remove($stage);
        $em->flush();
        return $this->redirectToRoute('stage.list');
    }
}
