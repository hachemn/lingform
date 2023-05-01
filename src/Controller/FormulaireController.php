<?php

namespace App\Controller;

use App\Entity\Formulaire;
use App\Form\FormulaireType;
use App\Repository\FormulaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/formulaire')]
class FormulaireController extends AbstractController
{
    #[Route('/', name: 'app_formulaire_index', methods: ['GET'])]
    public function index(FormulaireRepository $formulaireRepository): Response
    {
        return $this->render('formulaire/index.html.twig', [
            'formulaires' => $formulaireRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_formulaire_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FormulaireRepository $formulaireRepository): Response
    {
        $formulaire = new Formulaire();
        $form = $this->createForm(FormulaireType::class, $formulaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formulaireRepository->save($formulaire, true);

            return $this->redirectToRoute('app_formulaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('formulaire/new.html.twig', [
            'formulaire' => $formulaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_formulaire_show', methods: ['GET'])]
    public function show(Formulaire $formulaire): Response
    {
        return $this->render('formulaire/show.html.twig', [
            'formulaire' => $formulaire,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_formulaire_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Formulaire $formulaire, FormulaireRepository $formulaireRepository): Response
    {
        $form = $this->createForm(FormulaireType::class, $formulaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formulaireRepository->save($formulaire, true);

            return $this->redirectToRoute('app_formulaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('formulaire/edit.html.twig', [
            'formulaire' => $formulaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_formulaire_delete', methods: ['POST'])]
    public function delete(Request $request, Formulaire $formulaire, FormulaireRepository $formulaireRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$formulaire->getId(), $request->request->get('_token'))) {
            $formulaireRepository->remove($formulaire, true);
        }

        return $this->redirectToRoute('app_formulaire_index', [], Response::HTTP_SEE_OTHER);
    }
}
