<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Config;
use App\Form\ConfigType;
//use App\Entity\Config;
class InstallController extends AbstractController
{
    public function getConfig(){
        $em=$this->getDoctrine()->getManager();
        $config=$em->getRepository(Config::class)->find(1);
        return $config;
    }

    #[Route('/install', name: 'bk_install')]
    public function index(Request $request): Response
    {
        $config = new Config();
        $form = $this->createForm(ConfigType::class, $config);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($config);
            $entityManager->flush();

            dump('success');
        }

        return $this->render('install/index.html.twig', [
            'config' => $config,
            'form' => $form->createView(),
        ]);
    }
}
