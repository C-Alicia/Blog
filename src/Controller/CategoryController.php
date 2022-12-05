<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\PostType;
use App\Repository\CategoryRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CategoryController extends AbstractController
{

    private CategoryRepository $repo;

    public function __construct(CategoryRepository $repo)
    {
        $this->repo = $repo;
    }

 #[IsGranted('ROLE_USER')]
    #[Route('/category', name: 'category.index')]
    public function index(): Response
    {

        /*   $this->denyAccessUnlessGranted('ROLE_USER'); */

        $category = $this->repo->findAll();
        return $this->render(
            'category/index.html.twig',
            ['category' => $category]
        );
    }

  
    //On créer une categorie avec la méthode créate//
    #[route('/category/create', name: 'category.create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        /* $this->denyAccessUnlessGranted('ROLE_USER'); */
        $category = new Category;
        $name = trim($request->get('name'));
        
        $submit = trim($request->get('submit'));
        
        
        if (isset($submit) && !empty($name)) {
            $category->setName($name);
            $this->repo->add($category, true);
            
            return $this->redirect('/category');
        };
        
        $categorys = $this->repo->findAll();
        return $this->render('/category/index.html.twig', ['category' => $categorys]);
    }


    //Methode supprimer : on recupere avec l'id//
    #[route('/category/delete/{id}', name: 'category.delete', methods: ['POST'])]
    public function delete($id)
    {

        /*  $this->denyAccessUnlessGranted('ROLE_USER');*/
        $category = $this->repo->find($id);
        $posts = $category->getPosts();
        //On utlise la méthode empty pour verifier avec une condition si est vide avec posts//
        if ($posts->isEmpty()) {
            //Et on supprime avec remove la catégorie//
            $this->repo->remove($category, true);
        }
        return $this->redirect('/category');
    }


    #[route('/category/edit/{id}', name: 'category.edit', methods: ['POST'])]
    public function edit($id, Request $request): Response
    {
        $category = $this->repo->find($id);

        $nom = trim($request->get('nom'));
        $submit = trim($request->get('submit'));


        if (isset($submit) && !empty($nom)) {
            $category->setName($nom);
            $this->repo->update();
            return $this->redirect('/category');
        };
        return $this->render('/category/edit.html.twig', ['category' => $category]);
    }



    #[Route('/category/{id}', name: 'category.show') ]
    public function show($id): Response
    {
        /*    $this->denyAccessUnlessGranted('ROLE_USER'); */

        $category = $this->repo->find($id);
        $posts = $category->getPosts();

        return $this->render(
            'category/show.html.twig',
            ['posts' => $posts, 'category' => $category]
        );
    }
}
