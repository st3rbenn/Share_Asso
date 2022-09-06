<?php

namespace App\Controller;

use App\Entity\Deal;
use App\Entity\Material;
use App\Form\DealType;
use App\Repository\DealRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @isGranted("ROLE_USER")
 * @Route("/deal")
 */
class DealController extends AbstractController
{
    /**
     * @isGranted("ROLE_ADMIN")
     * @Route("/", name="app_deal_index", methods={"GET"})
     */
    public function index(DealRepository $dealRepository): Response
    {
        return $this->render('deal/index.html.twig', [
            'deals' => $dealRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id}", name="app_deal_new", methods={"GET", "POST"})
     */
    public function new(Material $id, Request $request, DealRepository $dealRepository): Response
    {
        $deal = new Deal();

        $form = $this->createForm(DealType::class, $deal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $deal->setMaterial($id);
            $deal->setAsso($this->getUser()->getAsso());
            $dealRepository->add($deal, true);
            $this->addFlash('success', 'Votre proposition a bien été envoyée');

            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }
        else if($form->isSubmitted() && !$form->isValid()){
            $this->addFlash('danger', 'Une erreur est survenue lors de l\'envoi de votre proposition');
        }

        return $this->renderForm('deal/new.html.twig', [
            'deal' => $deal,
            'form' => $form,
        ]);
    }

    

    /**
     * @Route("/{id}/edit", name="app_deal_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Deal $deal, DealRepository $dealRepository): Response
    {
        $form = $this->createForm(DealType::class, $deal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dealRepository->add($deal, true);

            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('deal/edit.html.twig', [
            'deal' => $deal,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_deal_delete", methods={"POST"})
     */
    public function delete(Request $request, Deal $deal, DealRepository $dealRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$deal->getId(), $request->request->get('_token'))) {
            $dealRepository->remove($deal, true);
        }

        return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @isGranted("ROLE_ADMIN")
     * @Route("/{id}", name="app_deal_show", methods={"GET"})
     */
    public function show(Deal $deal): Response
    {
        return $this->render('deal/show.html.twig', [
            'deal' => $deal,
        ]);
    }
}
