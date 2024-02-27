<?php

namespace App\Controller;

use App\Entity\Receptor;
use App\Entity\Config;
use App\Form\Receptor1Type;
use App\Form\ReceptorType;
use App\Repository\ReceptorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
//use App\Entity\Config;
/**
 * @Route("admin/receptor")
 */
class ReceptorController extends AbstractController
{

    public function getConfig(){
        $em=$this->getDoctrine()->getManager();
        $config=$em->getRepository(Config::class)->find(1);
        return $config;
    }

    /**
     * @Route("/", name="receptor_index", methods={"GET"})
     */
    public function index(ReceptorRepository $receptorRepository): Response
    {
        return $this->render('receptor/index.html.twig', [
            'receptors' => $receptorRepository->findAll(),
            'config'=>$this->getConfig()
        ]);
    }

    /**
     * @Route("/new", name="receptor_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $receptor = new Receptor();
        $form = $this->createForm(Receptor1Type::class, $receptor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($receptor);
            $entityManager->flush();

            return $this->redirectToRoute('receptor_index');
        }

        return $this->render('receptor/new.html.twig', [
            'receptor' => $receptor,
            'form' => $form->createView(),
            'config'=>$this->getConfig()
        ]);
    }

    /**
     * @Route("/{id}", name="receptor_show", methods={"GET"})
     */
    public function show(Receptor $receptor): Response
    {
        return $this->render('receptor/show.html.twig', [
            'receptor' => $receptor,
            'config'=>$this->getConfig()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="receptor_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Receptor $receptor): Response
    {
        $form = $this->createForm(Receptor1Type::class, $receptor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('receptor_index');
        }

        return $this->render('receptor/edit.html.twig', [
            'receptor' => $receptor,
            'form' => $form->createView(),
            'config'=>$this->getConfig()
        ]);
    }

    /**
     * @Route("/{id}", name="receptor_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Receptor $receptor): Response
    {
        if ($this->isCsrfTokenValid('delete'.$receptor->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($receptor);
            $entityManager->flush();
        }

        return $this->redirectToRoute('receptor_index');
    }
    public function addDest(){
        $request=Request::createFromGlobals();
        $receptor = new Receptor();
        $receptor->setDate(new \DateTime());
        $receptor->setVerificode(rand(111111,999999));
        $receptor->setIsVerify(false);
        $form = $this->createForm(ReceptorType::class, $receptor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $receptor->setUser($this->getUser()->getUser());
            $this->getUser()->getUser()->addReceptor($receptor);
            $this->addFlash(
                'success',
                'Recipient successfully added!'
            );
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($receptor);
            $entityManager->flush();

            return $this->redirectToRoute('bk_recip');
        }

        return $this->render('test3.html.twig', [
            'receptor' => $receptor,
            'form' => $form->createView(),
            'config'=>$this->getConfig()
        ]);
    }
}
