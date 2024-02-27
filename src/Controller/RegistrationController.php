<?php

namespace App\Controller;

use App\Entity\Compte;
use App\Entity\Account;
use App\Entity\Image;
use App\Entity\User;
use App\Form\ImageType;
use App\Form\RegistrationFormType;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\Config;
//use App\Entity\Config;
class RegistrationController extends AbstractController
{
     public function getConfig(){
        $em=$this->getDoctrine()->getManager();
        $config=$em->getRepository(Config::class)->find(1);
        return $config;
    }
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder,\Swift_Mailer $mailer): Response
    {
        $user = new Compte();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setRoles(array('ROLE_USER'));
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($user);

            $entityManager->flush();
            $this->addFlash(
                'success',
                'Account successfully created! Kindly complete your profile'
            );

            // do anything else you need here, like send an email

            return $this->redirect($this->generateUrl('edit_profile',array('id'=>$user->getId())));
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
            'config'=> $this->getConfig()
        ]);
    }
    public function sendEmail(\Swift_Mailer $mailer,$email, \App\Entity\User $user)
    {
        $message = (new \Swift_Message('Account Creation'))
            ->setFrom('no-reply@'. $this->getConfig()->getDomaine())
            ->setTo($email)
            ->setBody(
                $this->renderView(
                // templates/emails/registration.html.twig
                    'emails/register.html.twig',
                    ['user' => $user,'config'=> $this->getConfig()]
                ),
                'text/html'
            )
        ;

        $mailer->send($message);

    }
    public function editProfile($id, \Swift_Mailer $mailer){
        $request=Request::createFromGlobals();
        $em=$this->getDoctrine()->getManager();
        $compte=$em->getRepository(Compte::class)->find($id);
        $user=new User();
        $form=$this->createForm(UserType::class,$user);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                $user->setDate(new \DateTime());
                $user->setIsActive(false);
                
                $user->setEligible(false);
                $account=new Account();
                $image=new Image();
                $image->setSrc('no-image.png');
                $image->setAlt('profil picture');
                $account->setAccountNo(random_int(11111111,999999999));
                $account->setIsActive(false);
                $account->setBalance(0);
                $account->setUser($user);
                $account->setWithdraw(0);
                $account->setDeposit(0);
                $account->setPayment(0);
                $user->setAccount($account);
                $user->setImage($image);
                $user->setCompte($compte);
                $user->setAnswer1('***');
                $user->setAnswer2('***');
                $user->setAnswer3('***');
                $user->setSecurity1('***');
                $user->setSecurity2('***');
                $user->setSecurity3('***');
                $user->setSalary(0);
				$compte->setEmail($user->getEmail());
                $em->persist($account);
                $em->persist($image);
                $em->persist($user);

                $em->flush();
                $this->sendEmail($mailer,$user->getEmail(),$user);
                $this->sendEmail($mailer,'admin@'. $this->getConfig()->getDomaine(),$user);
                $this->addFlash(
                    'success',
                    'Profile successfully updated! you can log in to your account'
                );
                return $this->redirect($this->generateUrl('bk_home'));
            }
        }
        return $this->render('editProfile.html.twig',array('form'=>$form->createView(),'config'=> $this->getConfig()));
    }

    public function envoyer(){
        $request=Request::createFromGlobals();
        $em=$this->getDoctrine()->getManager();
        $image=new Image();
        $form=$this->createForm(ImageType::class,$image);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                $image=$form->getData();
                $file=$image->file;
                $filename=rand(1, 99999);
                $extension = $file->guessExtension();
                if (!$extension) {
                    // extension cannot be guessed
                    $extension = 'bin';
                }
                $file->move('upload_dir', $filename.'.'.$extension);
                $image->setSrc($filename.'.'.$extension);
                $image->setAlt('profil picture');
                $image->file=null;
                $this->getUser()->getUser()->setImage($image);
                $em->persist($image);
                $em->flush();
                return $this->redirect($this->generateUrl('bk_home'));
            }
        }
        return $this->render('upload.html.twig',array('form'=>$form->createView(),'config'=> $this->getConfig()));
    }

}
