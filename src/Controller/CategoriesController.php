<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Stage;
use App\Form\CategorieType;
use App\Form\StageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoriesController extends AbstractController
{
    /**
     * @Route("/categories", name="categorie.list")
     */
    public function list(): Response
    {
        $categories=$this->getDoctrine()->getRepository(Categorie::class)->getCategoriesAvecStagesNonExpires();

        return $this->render('categories/list.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * Créer une nouvelle categorie.
     * @Route("/admin/nouvelle-categorie", name="categorie.create")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     */
    public function create(Request $request, EntityManagerInterface $em) : Response
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($categorie);
            $em->flush();
            return $this->redirectToRoute('stage.list');
        }
        return $this->render('categories/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }


}
