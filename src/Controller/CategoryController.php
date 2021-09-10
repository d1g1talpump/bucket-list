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
     * @Route("/category/list/{categoryId}", name="category_list")
     */
    public function listByCategory(int $categoryId ,WishRepository $wishRepository): Response
    {
        $allWishesByCategory = $wishRepository->findByCategory($categoryId);

        return $this->render('category/list.html.twig', [
            "allWishesByCategory" => $allWishesByCategory
        ]);
    }
}
