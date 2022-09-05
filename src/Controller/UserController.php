<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Symfony\Component\Mime\Email;
use App\Repository\UserRepository;
use App\Repository\AssociationRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="app_user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/new", name="app_user_new", requirements={"id"="\d+"}, methods={"GET", "POST"})
     */
    public function new(Request $request, UserRepository $userRepository, AssociationRepository $associationRepository,UserPasswordHasherInterface $userPasswordHasherInterface, FileUploader $fileUploader, int $id, MailerInterface $mailer): Response

    {
        $user = new User();
        $user->setAsso($associationRepository->find($id));
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($userPasswordHasherInterface->hashPassword($user, $user->getPassword()));

            $message = (new Email())
                ->from(new Address('test@example.com'))
                //->to($user->getEmail())
                ->to('test@gmail.com')
                ->subject('Bienvenue sur le site de Share Asso')
                ->text('Merci de vous être inscrit sur notre site !')
                ->html('<p>Merci de vous être inscrit sur notre site !</p>');
                //->html('email/register.html.twig')
                //->context([
                    //'user' => $user,
                //]);
                ;
            $mailer->send($message);

            $userRepository->add($user);
            $file = $form['user_avatar']->getData();

            if($file){
                $fileName = $fileUploader->upload($file);
                $user->setUserAvatar($fileName);
                $userRepository->add($user);
            }
            $this->addFlash('success', 'Votre compte a bien été créé');

            return $this->redirectToRoute('login', [], Response::HTTP_SEE_OTHER);
        }
        else if($form->isSubmitted() && !$form->isValid()){
            $this->addFlash('danger', 'Une erreur est survenue lors de la création de votre compte');
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
            'id' => $id,
        ]);
    }

    /**
     * @Route("/{id}", name="app_user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_user_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, User $user, UserRepository $userRepository, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user);

            $file = $form['user_avatar']->getData();

            if($file){
                $fileName = $fileUploader->upload($file);
                $user->setUserAvatar($fileName);
                $userRepository->add($user);
            }

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
