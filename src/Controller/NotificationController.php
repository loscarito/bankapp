<?php

namespace App\Controller;

use App\Entity\Notification;
use App\Form\Notification1Type;
use App\Repository\NotificationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Config;
/**
 * @Route("/notification")
 */
class NotificationController extends AbstractController
{
    public function getConfig(){
        $em=$this->getDoctrine()->getManager();
        $config=$em->getRepository(Config::class)->find(1);
        return $config;
    }

    /**
     * @Route("/", name="notification_index", methods={"GET"})
     */
    public function index(NotificationRepository $notificationRepository): Response
    {
        return $this->render('notification/index.html.twig', [
            'notifications' => $notificationRepository->findAll(),
            'config'=>$this->getConfig()
        ]);
    }

    /**
     * @Route("/new", name="notification_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $notification = new Notification();
        $form = $this->createForm(Notification1Type::class, $notification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($notification);
            $entityManager->flush();

            return $this->redirectToRoute('notification_index');
        }

        return $this->render('notification/new.html.twig', [
            'notification' => $notification,
            'form' => $form->createView(),
            'config'=>$this->getConfig()
        ]);
    }

    /**
     * @Route("/{id}", name="notification_show", methods={"GET"})
     */
    public function show(Notification $notification): Response
    {
        return $this->render('notification/show.html.twig', [
            'notification' => $notification,
            'config'=>$this->getConfig()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="notification_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Notification $notification): Response
    {
        $form = $this->createForm(Notification1Type::class, $notification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('notification_index');
        }

        return $this->render('notification/edit.html.twig', [
            'notification' => $notification,
            'form' => $form->createView(),
            'config'=>$this->getConfig()
        ]);
    }

    /**
     * @Route("/{id}", name="notification_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Notification $notification): Response
    {
        if ($this->isCsrfTokenValid('delete'.$notification->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($notification);
            $entityManager->flush();
        }

        return $this->redirectToRoute('notification_index');
    }
}
