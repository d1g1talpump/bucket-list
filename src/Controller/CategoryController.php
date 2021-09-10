<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\WishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category/", name="category_list")
     */
    public function list(CategoryRepository $categoryRepository): Response
    {
        $allCategories = $categoryRepository->findAll();

        return $this->render('category/list.html.twig', [
            "allCategories" => $allCategories
        ]);
    }
}
