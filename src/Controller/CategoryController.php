<?php
// src/Controller/ProgramController.php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;

#[Route('/category', name: 'category_')]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/show/{id<^[0-9]+$>}', name: 'show')]
    public function show(
        int $id,
        ProgramRepository $programRepository
    ): Response {
        $programs = $programRepository->findBy(
            ['category' => $id],
            ['id' => 'desc'],
            3
        );
        if (!$programs) {
            throw $this->createNotFoundException(
                'No program with this category : ' . $id
            );
        }
        return $this->render('category/show.html.twig', [
            'programs' => $programs,
        ]);
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request,CategoryRepository $categoryRepository): Response 
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class,$category);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $categoryRepository->save($category, true);            
            return $this->redirectToRoute('category_index');
        }
        return $this->renderForm('category/new.html.twig',['form' => $form]);
    }
}
