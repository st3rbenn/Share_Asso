<?php

namespace App\Controller;

use App\Entity\Association;
use App\Entity\Deal;
use App\Entity\Material;
use App\Form\MaterialType;
use App\Service\FileUploader;
use Symfony\Component\Mime\Email;
use App\Repository\DealRepository;
use Symfony\Component\Mime\Address;
use App\Repository\MaterialRepository;
use App\Repository\DealRepository;
use App\Service\FileUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\AssociationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/material")
 */
class MaterialController extends AbstractController
{
    /**
     * @Route("/{id}", name="app_material_show", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function show(Material $material, DealRepository $dealRepository, Deal $deal): Response
    {

        $deals = $dealRepository->findByMaterial($material);
        $dealed = [];
        foreach($deals as $deal) {
            $dealed = $deal->getAsso() === $this->getUser()->getAsso() ? true : false;
        }

        return $this->render('material/show.html.twig', [
            'material' => $material,
            'deal' => $deal,
            'deals' => $deals,
            'dealed' => $dealed,
        ]);
    }
    
    /**
     * @Route("/", name="app_material_index", methods={"GET"})
     */
    public function index(MaterialRepository $materialRepository): Response
    {
        $materials = $materialRepository->findAll();
        return $this->render('material/index.html.twig', [
            'materials' => $materials,
        ]);
    }

    /**
     * @Route("/new", name="app_material_new")
     */
    public function new(
        FileUploader $fileUploader,
        Request $request,
        MaterialRepository $materialRepository,
        AssociationRepository $associationRepository,
        MailerInterface $mailer
    ): Response
    {
        $material = new Material();
        
        $form = $this->createForm(MaterialType::class, $material);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $material->setAsso($this->getUser()->getAsso());
            $materialRepository->add($material);

            $file = $form['material_img']->getData();

            if($file){
                $fileName = $fileUploader->upload($file);
                $material->setMaterialImg($fileName);
                $materialRepository->add($material);
            }
            $this->addFlash('success', 'Votre matériel a bien été ajouté');
            $email = (new Email())
                ->from(new Address('test@example.com'))
                ->to('test@example.com')
                ->subject('Nouveau matériel ajouté')
                ->text('Un nouveau matériel a été ajouté sur votre site')
                ->html('<p>Un nouveau matériel a été ajouté sur votre site</p>');
            $mailer->send($email);

            return $this->redirectToRoute('app_association_index', ['id' => $material->getAsso()->getId()], Response::HTTP_SEE_OTHER);
        }
        else if($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('danger', 'Une erreur est survenue lors de l\'ajout de votre matériel');
        }

        return $this->renderForm('material/new.html.twig', [
            'material' => $material,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_material_edit", methods={"GET", "POST"})
     */
    public function edit(
        Request $request,
        Material $material,
        MaterialRepository $materialRepository,
        FileUploader $fileUploader
    ): Response
    {
        $form = $this->createForm(MaterialType::class, $material);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $materialRepository->add($material);

            $file = $form['material_img']->getData();

            if($file){
                $fileName = $fileUploader->upload($file);
                $material->setMaterialImg($fileName);
                $materialRepository->add($material);
            }

            return $this->redirectToRoute('app_material_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('material/edit.html.twig', [
            'material' => $material,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_material_delete", methods={"POST"})
     */
    public function delete(Request $request, Material $material, MaterialRepository $materialRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$material->getId(), $request->request->get('_token'))) {
            $materialRepository->remove($material, true);
        }

        return $this->redirectToRoute('app_material_index', [], Response::HTTP_SEE_OTHER);
    }
}
