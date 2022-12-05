<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ContactController extends AbstractController
{

    public function __construct(ContactRepository $repo)
    {
        $this->repo = $repo;
    }

    #[Route('/contact', name: 'contact.create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {

        $submit = $request->get('submit');
        $errors = [];
        //Affichage du formulaire//

        //TRAITEMENT DES INFORMATIONS//

        $name = trim($request->get('name'));
        if (empty($name)) {

            [$errors['name'] = 'le nom est obligatoire'];
        }

        $email = trim($request->get('email'));
        if (empty($email)) {
            [$errors['email'] = 'l\'email est obligatoire'];
        }


        $phone = trim($request->get('phone'));
        if (empty($phone)) {
            [$errors["phone"] = 'le téléphone est obligatoire'];
        }

        $message = trim($request->get('message'));
        if (empty($message)) {
            [$errors['message'] = 'Le message est obligatoire'];
        }

        $data = ['name' => $name, 'email' => $email, 'phone' => $phone, 'message' => $message];

        if (!isset($submit)) {
            return $this->render('contact/create.html.twig', ['data' => $data]);
            /*             $this->addFlash('success', 'Message bien envoyé'); */
        }
        
        if (empty($errors)) {
            
            $contact = new Contact;
            $contact->setName($name);
            $contact->setMessage($message);
            $contact->setPhone($phone);
            $contact->setEmail($email);
            
            $this->repo->add($contact, true);
            return $this->redirect('/');
        } else {
            return $this->renderForm('/contact/create.html.twig', ['errors' => $errors, 'data' => $data]);
        }
    }
}
