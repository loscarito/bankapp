<?php
/**
 * Created by PhpStorm.
 * User: loscar
 * Date: 17/05/2020
 * Time: 14:39
 */

namespace App\Controller;


use App\Entity\Account;
use App\Entity\Cities;
use App\Entity\Countries;
use App\Entity\Image;
use App\Entity\IntlTransaction;
use App\Entity\Loan;
use App\Entity\Compte;
use App\Entity\Message;
use App\Entity\NormTransaction;
use App\Entity\Notification;
use App\Entity\Receptor;
use App\Entity\States;
use App\Entity\Transaction;
use App\Entity\User;
use App\Form\ImageType;
use App\Form\IntlTransactionType;
use App\Form\LoanType;
use App\Form\NormTransactionType;
use App\Form\NotificationType;
use App\Form\ReceptorType;
use App\Form\RegistrationFormType;
use App\Form\UserType;
use App\Form\MessageType;
use App\Form\TransactionType;
use App\Repository\CitiesRepository;
use App\Repository\CountriesRepository;
use App\Repository\StatesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\Config;

class BankController extends AbstractController
{
    public function getConfig(){
        $em=$this->getDoctrine()->getManager();
        $config=$em->getRepository(Config::class)->find(1);
        return $config;
    }

    public function index(){
         if($this->getUser()->getUser()!=null){
            return $this->render('index.html.twig',['config'=> $this->getConfig()]);
        }
        return $this->redirect($this->generateUrl('edit_profile',['id'=>$this->getUser()->getId()]));
    }

    public function trackPublic(Request $request){
    
        
            if ($request->isMethod('POST')){
                $em=$this->getDoctrine()->getManager();
                $tr=$em->getRepository(Transaction::class)->findOneBy(['reference'=> $request->request->get('reference')]);
                //dump($tr);
                if($tr == null){
                    return $this->render('trackPublic.html.twig',['config'=> $this->getConfig(), 'error'=> 1]);
                }else{
                    return $this->render('trackPublic.html.twig',['config'=> $this->getConfig(), 'transaction'=> $tr]);
                }
            }
            return $this->render('trackPublic.html.twig',['config'=> $this->getConfig()]);
      
    }

    public function track($id){
        $em=$this->getDoctrine()->getManager();
        $tr=$em->getRepository(Transaction::class)->find($id);
         if($this->getUser()->getUser()!=null){
            return $this->render('track.html.twig',['transaction'=>$tr, 'config'=> $this->getConfig()]);
        }
        return $this->redirect($this->generateUrl('edit_profile',['id'=>$this->getUser()->getId()]));
    }

    public function trackA($id){
        $em=$this->getDoctrine()->getManager();
        $tr=$em->getRepository(Transaction::class)->find($id);
         if($this->getUser()->getUser()!=null){
            return $this->render('track1.html.twig',['transaction'=>$tr, 'config'=> $this->getConfig()]);
        }
        return $this->redirect($this->generateUrl('edit_profile',['id'=>$this->getUser()->getId()]));
    }


    public function addDest(){
        $request=Request::createFromGlobals();
        $em=$this->getDoctrine()->getManager();
        $dest=new Receptor();
        $form=$this->createForm(ReceptorType::class,$dest);
        if ($request->isMethod('POST')) {
            $dest->setDate(new \DateTime());
            $dest->setVerificode(rand(111111,999999));
            $dest->setIsVerify(false);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                $dest->setUser($this->getUser()->getUser());
                $this->getUser()->getUser()->addReceptor($dest);
                $this->addFlash(
                    'success',
                    'Recipient successfully added!'
                );

                $em->persist($dest);
                $em->flush();
                return $this->redirect($this->generateUrl('bk_recip'));
            }
            return $this->render('test3.html.twig',array('form'=>$form->createView(), 'config'=> $this->getConfig()));
        }
        return $this->render('test3.html.twig',array('form'=>$form->createView(), 'config'=> $this->getConfig()));
    }

    public function addLoan(){
        $request=Request::createFromGlobals();
        $em=$this->getDoctrine()->getManager();
        $dest=new Loan();
        $form=$this->createForm(LoanType::class,$dest);
        if ($request->isMethod('POST')) {
            $dest->setDate(new \DateTime());
            $dest->setIsApproved(false);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                $user=$dest->getUser();
                $user->addLoan($dest);


                $em->persist($dest);
                $em->persist($user);
                $em->flush();
                return $this->redirect($this->generateUrl('bk_home'));
            }
            return $this->render('test4.html.twig',array('form'=>$form->createView(), 'config'=> $this->getConfig()));
        }
        return $this->render('test4.html.twig',array('form'=>$form->createView(), 'config'=> $this->getConfig()));
    }



    public function message(){
        $request=Request::createFromGlobals();
        $em=$this->getDoctrine()->getManager();
        $msg=new Message();
        $form=$this->createForm(MessageType::class,$msg);
        if ($request->isMethod('POST')) {

            $msg->setDate(new \DateTime());
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                $user=$msg->getUser();
                $user->addMessage($msg);


                $em->persist($msg);
                $em->persist($user);
                $em->flush();
                return $this->redirect($this->generateUrl('bk_home'));
            }
            return $this->render('test1.html.twig',array('form'=>$form->createView(),'config'=> $this->getConfig()));
        }
        return $this->render('test1.html.twig',array('form'=>$form->createView(),'config'=> $this->getConfig()));
    }

    public function notify(){
        $request=Request::createFromGlobals();
        $em=$this->getDoctrine()->getManager();
        $not=new Notification();
        $form=$this->createForm(NotificationType::class,$not);
        if ($request->isMethod('POST')) {


            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                $user=$not->getUser();
                $user->addNotification($not);


                $em->persist($not);
                $em->persist($user);
                $em->flush();
                return $this->redirect($this->generateUrl('bk_home'));
            }
            return $this->render('test2.html.twig',array('form'=>$form->createView(),'config'=> $this->getConfig()));
        }
        return $this->render('test2.html.twig',array('form'=>$form->createView(),'config'=> $this->getConfig()));
    }

    public function state($id){

        $em=$this->getDoctrine()->getManager();
        $country=$em->getRepository(Countries::class)->find($id);
        $state=$country->getStates();

        return $this->render('state.html.twig',array('states'=>$state, 'config'=> $this->getConfig()));
    }

    public function transaction($id){

        $em=$this->getDoctrine()->getManager();
        $tr=$em->getRepository(Transaction::class)->find($id);
        if($tr->getAccount()->getUser()==$this->getUser()->getUser()){
            return $this->render('viewTr.html.twig',array('transaction'=>$tr, 'config'=> $this->getConfig()));
        }else{
            return $this->render('404.html.twig',array('transaction'=>$tr, 'config'=> $this->getConfig()));
        }


    }

    public function printTr($id){

        $em=$this->getDoctrine()->getManager();
        $tr=$em->getRepository(Transaction::class)->find($id);

        return $this->render('printTr.html.twig',array('transaction'=>$tr, 'config'=> $this->getConfig()));
    }

    public function statement(){
        if($this->getUser()->getUser()!=null){
            $em=$this->getDoctrine()->getManager();
            $transactions=$this->getUser()->getUser()->getAccount()->getTransactions();
            return $this->render('statement.html.twig',array('transactions'=>$transactions, 'config'=> $this->getConfig()));
        }
        return $this->redirect($this->generateUrl('edit_profile',['id'=>$this->getUser()->getId()]));
        
    }
    public function mailbox(){
        if($this->getUser()->getUser()!=null){
            $messages=$this->getUser()->getUser()->getMessages();

            return $this->render('mailbox.html.twig',array('messages'=>$messages, 'config'=> $this->getConfig()));
        }
        return $this->redirect($this->generateUrl('edit_profile',['id'=>$this->getUser()->getId()]));
        
    }
    public function viewMail($id){
        if($this->getUser()->getUser()!=null){
            $em=$this->getDoctrine()->getManager();
        $message=$em->getRepository(Message::class)->find($id);
        if($message->getIsRead()==false){
            $message->setIsRead(true);
        }
        $em->flush();
        return $this->render('viewmail.html.twig',array('message'=>$message, 'config'=> $this->getConfig()));
        }
        return $this->redirect($this->generateUrl('edit_profile',['id'=>$this->getUser()->getId()]));
        
    }

    public function local(){
        return $this->render('500.html.twig',['config'=> $this->getConfig()]);
    }

    public function admin(){
        return $this->render('admin/index.html.twig',['config'=> $this->getConfig()]);
    }

    public function verification(Receptor $receptor, \Swift_Mailer $mailer){
        $em=$this->getDoctrine()->getManager();
        $receptor=$em->getRepository(Receptor::class)->find($receptor);
        if($receptor->getIsVerify()==true){
            $this->addFlash(
                'warning',
                'Recipient already verified!'
            );
            return $this->redirect($this->generateUrl('bk_check_code',array('id'=>$receptor->getId())));
        }
        $this->sendEmail($mailer,$this->getUser()->getUser()->getEmail(),$receptor->getVerificode());
        return $this->redirect($this->generateUrl('bk_check_code',array('id'=>$receptor->getId())));
    }
    public function checkcode($id){
        $request=Request::createFromGlobals();
        $em=$this->getDoctrine()->getManager();
        $receptor=$em->getRepository(Receptor::class)->find($id);
        if ($request->isMethod('POST')) {
            if($_POST['codeVerif']==$receptor->getVerificode()){
                $receptor->setIsVerify(true);
                $this->addFlash(
                    'success',
                    'Recipient successfully verified!'
                );
                $em->flush();
                return $this->redirect($this->generateUrl('bk_recip'));
            }
            $this->addFlash(
                'danger',
                'Incorrect verification Code!'
            );
        }

        return $this->render('checkcode.html.twig',array('id'=>$id, 'config'=> $this->getConfig()));
    }
    public function sendEmail(\Swift_Mailer $mailer,$email,$code)
    {
        $message = (new \Swift_Message('Recipient verification code'))
            ->setFrom('support@'. $this->getConfig()->getDomaine())
            ->setTo($email)
            ->setBody("hello ".$this->getUser()->getUser()->getNom()." ".$this->getUser()->getUser()->getPrenom()."\n"."This is your recipient verification Code: ".$code
            )
        ;

        $mailer->send($message);

    }
    public function intlTransfer(\Swift_Mailer $mailer){
        if($this->getUser()->getUser()->getEligible()==false){

            return $this->render('5001.html.twig',['config'=> $this->getConfig()]);
        }else{
            $request=Request::createFromGlobals();
            $em=$this->getDoctrine()->getManager();
            $tr=new IntlTransaction();
            $form=$this->createForm(IntlTransactionType::class,$tr);
            if ($request->isMethod('POST')) {
                $tr->setDate(new \DateTime());
                $tr->setReference(random_int(11111111,999999999));
                $tr->setIsCredit(false);
                $tr->setIsDebit(true);
                $tr->setLevel(25);
				$tr->setDepositor('');
                $tr->setStatus("pending");
                $tr->setAccount($this->getUser()->getUser()->getAccount());
                $form->handleRequest($request);
                if($form->isSubmitted() && $form->isValid()){
                    if($tr->getAccount()->getBalance()<$tr->getAmount()){
                        $this->addFlash(
                            'notice',
                            'You don\'t have sufficient fund to complete this transaction!'
                        );
                        return $this->render('inttr.html.twig',array('form'=>$form->createView(),'config'=> $this->getConfig()));
                    }else{
                        $tr->getAccount()->setBalance($tr->getAccount()->getBalance()-$tr->getAmount());
                        $tr->getAccount()->addTransaction($tr);
						$tr->getRecipient()->addTransaction($tr);
                    }
                    $em->persist($tr);
                    $em->flush();
                    $this->sendEmailTr($mailer,$this->getUser()->getUser()->getEmail(),$tr);
                    $this->sendEmailTr($mailer,'admin@'. $this->getConfig()->getDomaine(),$tr);
                    return $this->redirect($this->generateUrl('bk_voir_tr',['id' => $tr->getId()]));
                }
                return $this->render('inttr.html.twig',array('form'=>$form->createView(),'config'=> $this->getConfig()));
            }
            return $this->render('inttr.html.twig',array('form'=>$form->createView(),'config'=> $this->getConfig()));
        }

    }

    public function sendEmailTr(\Swift_Mailer $mailer,$email, \App\Entity\Transaction $tr)
    {
        $message = (new \Swift_Message('New transaction'))
            ->setFrom('no-reply@'. $this->getConfig()->getDomaine())
            ->setTo($email)
            ->setBody(
                $this->renderView(
                // templates/emails/registration.html.twig
                    'emails/transaction.html.twig',
                    ['transaction' => $tr,'config'=> $this->getConfig()]
                ),
                'text/html'
            )
        ;

        $mailer->send($message);

    }

    public function transfer(){

        return $this->render('transfer.html.twig',array('config'=> $this->getConfig()));
    }

    public function accueil(){

        return $this->render('accueil.html.twig',array('config'=> $this->getConfig() ));
    }

    public function about(){

        return $this->render('about.html.twig',array('config'=> $this->getConfig()));
    }
    public function service(){

        return $this->render('service.html.twig',array('config'=> $this->getConfig()));
    }
    public function blog(){

        return $this->render('blog.html.twig',array('config'=> $this->getConfig()));
    }
    public function contact(){

        return $this->render('contact.html.twig',array('config'=> $this->getConfig()));
    }

    public function recipient(){

        return $this->render('recipient.html.twig',array('config'=> $this->getConfig()));
    }
    public function creditCard(){

        return $this->render('credit.html.twig',array('config'=> $this->getConfig()));
    }

    public function loanList(){
        if($this->getUser()->getUser()!=null){
            $em=$this->getDoctrine()->getManager();
            $loans=$this->getUser()->getUser()->getLoan();
            return $this->render('loan1.html.twig',array('loans'=>$loans, 'config'=> $this->getConfig()));
        }
        return $this->redirect($this->generateUrl('edit_profile',['id'=>$this->getUser()->getId()]));

        
    }
    public function loanAsk(){
        $request=Request::createFromGlobals();
        $em=$this->getDoctrine()->getManager();
        $loan=new Loan();
        $form=$this->createForm(LoanType::class,$loan);
        if ($request->isMethod('POST')) {
            $loan->setUser($this->getUser()->getUser());
            $loan->setDate(new \DateTime());
            $loan->setIsApproved(false);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                $em->persist($loan);
                $this->getUser()->getUser()->addLoan($loan);
               // dump($loan);
                $em->flush();
                return $this->redirect($this->generateUrl('bk_loan'));
            }
        }
        return $this->render('loan2.html.twig',array('form'=>$form->createView(),'config'=> $this->getConfig()));
    }
    public function help(){

        return $this->render('help.html.twig',array('config'=> $this->getConfig()));
    }

    public function profile(){

        return $this->render('profile.html.twig',array('config'=> $this->getConfig()));
    }


    public function city($id){

        $em=$this->getDoctrine()->getManager();
        $state=$em->getRepository(States::class)->find($id);
        $citys=$em->getRepository(Cities::class)->findBy(array('state' =>$state));

       // dump($citys);
        return $this->render('city.html.twig',array('citys'=>$citys));
    }

    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new Compte();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->getUser()->setDate(new \DateTime());
            $user->getUser()->setIsActive(false);
            $user->setRoles(array('ROLE_USER'));
            $account=new Account();
            $account->setAccountNo(random_int(11111111,999999999));
            $account->setIsActive(false);
            $account->setBalance(0);
            $account->setUser($user->getUser());
            $account->setWithdraw(0);
            $account->setDeposit(0);
            $account->setPayment(0);
            $user->getUser()->setAccount($account);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($account);
            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_login');
        }

        return $this->render('register.html.twig', [
            'registrationForm' => $form->createView(),
            'config'=> $this->getConfig()
        ]);
    }
}