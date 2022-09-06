<?php

namespace App\Controller;

use App\Repository\MaterialRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(MaterialRepository $materialRepository): Response
    {
        $materials = $materialRepository->findAll();
        usort($materials, function ($a, $b) {
            return $a->getMaterialCreatedat() <=> $a->getMaterialCreatedat();
        });
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'materials' => $materials,
        ]);
    }
}
