<?php

namespace App\Controller;

use App\Entity\InfoTr;
use App\Entity\Transaction;
use App\Form\InfoTrType;
use App\Repository\InfoTrRepository;
use App\Repository\TransactionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Config;
#[Route('admin/info/tr')]
class InfoTrController extends AbstractController
{
    public function getConfig(){
        $em=$this->getDoctrine()->getManager();
        $config=$em->getRepository(Config::class)->find(1);
        return $config;
    }

    #[Route('/{id}', name: 'info_tr_index', methods: ['GET'])]
    public function index(TransactionRepository $infoTrRepository,$id): Response
    {
        return $this->render('info_tr/index.html.twig', [
            'info_trs' => $infoTrRepository->find($id)->getInfoTrs(),
            'id'=>$id,'config'=>$this->getConfig()
        ]);
    }

    #[Route('/new/{id}', name: 'info_tr_new', methods: ['GET','POST'])]
    public function new(Request $request,$id): Response
    {
        $infoTr = new InfoTr();
        $em=$this->getDoctrine()->getManager();
        $transaction=$em->getRepository(transaction::class)->find($id);
        dump($transaction);
        $form = $this->createForm(InfoTrType::class, $infoTr);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $transaction->addInfoTr($infoTr);
            $infoTr->setTransaction($transaction);
           // dump($infoTr);
            $entityManager->persist($infoTr);
            $entityManager->flush();

            return $this->redirectToRoute('info_tr_index', ['id'=>$id], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('info_tr/new.html.twig', [
            'info_tr' => $infoTr,
            'form' => $form,
            'id'=>$id,
            'config'=>$this->getConfig()
        ]);
    }

    #[Route('/voir/{id}/{sid}', name: 'info_tr_show', methods: ['GET'])]
    public function show(InfoTr $infoTr,$sid): Response
    {
        return $this->render('info_tr/show.html.twig', [
            'info_tr' => $infoTr,
            'sid'=>$sid,
            'config'=>$this->getConfig()
        ]);
    }

    #[Route('/mod/{id}/{sid}/edit', name: 'info_tr_edit', methods: ['GET','POST'])]
    public function edit(Request $request, InfoTr $infoTr, $sid): Response
    {
        $form = $this->createForm(InfoTrType::class, $infoTr);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('info_tr_index', ['id'=>$sid], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('info_tr/edit.html.twig', [
            'info_tr' => $infoTr,
            'form' => $form,
            'config'=>$this->getConfig()
        ]);
    }

    #[Route('/voir/{id}', name: 'info_tr_delete', methods: ['POST'])]
    public function delete(Request $request, InfoTr $infoTr): Response
    {
        if ($this->isCsrfTokenValid('delete'.$infoTr->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($infoTr);
            $entityManager->flush();
        }

        return $this->redirectToRoute('info_tr_index', ['id'=>$infoTr->getTransaction()->getId()], Response::HTTP_SEE_OTHER);
    }
}
