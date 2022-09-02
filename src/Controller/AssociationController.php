<?php

namespace App\Controller;

use App\Entity\Association;
use App\Entity\User;
use App\Form\RegisterAssociationType;
use App\Repository\AssociationRepository;
use App\Repository\MaterialRepository;
use App\Service\FileUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/association")
 */
class AssociationController extends AbstractController
{
    /**
     * @Route("/", name="app_association_index", methods={"GET"})
     */
    public function index(
        AssociationRepository $associationRepository,
        MaterialRepository $materialRepository
    ): Response
    {
        $materials = $materialRepository->findAll();
        return $this->render('association/index.html.twig', [
            'associations' => $associationRepository->findAll(),
            'materials' => $materials,
        ]);
    }

    /**
     * @Route("/new", name="app_association_new", methods={"GET", "POST"})
     */
    public function new(Request $request, AssociationRepository $associationRepository, FileUploader $fileUploader): Response
    {
        $association = new Association();
        $form = $this->createForm(RegisterAssociationType::class, $association);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $associationRepository->add($association);
            $file = $form['association_img']->getData();

            if($file){
                $fileName = $fileUploader->upload($file);
                $association->setAssociationImg($fileName);
                $associationRepository->add($association);
            }

            return $this->redirectToRoute('app_user_new', ['id' => $association->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('association/new.html.twig', [
            'association' => $association,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_association_show", methods={"GET"})
     */
    public function show(Association $association): Response
    {
        return $this->render('association/show.html.twig', [
            'association' => $association,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_association_edit", methods={"GET", "POST"})
     */
    public function edit(
        Request $request,
        Association $association,
        AssociationRepository $associationRepository,
        FileUploader $fileUploader
    ): Response
    {
        $form = $this->createForm(RegisterAssociationType::class, $association);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $associationRepository->add($association);

            $file = $form['association_img']->getData();

            if($file){
                $fileName = $fileUploader->upload($file);
                $association->setAssociationImg($fileName);
                $associationRepository->add($association);
            }
            return $this->redirectToRoute('app_association_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('association/edit.html.twig', [
            'association' => $association,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_association_delete", methods={"POST"})
     */
    public function delete(Request $request, Association $association, AssociationRepository $associationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$association->getId(), $request->request->get('_token'))) {
            $associationRepository->remove($association, true);
        }

        return $this->redirectToRoute('app_association_index', [], Response::HTTP_SEE_OTHER);
    }
}
