<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\AddWishType;
use App\Repository\CategoryRepository;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("/wish", name="wish_")
 */
class WishController extends AbstractController
{
    /**
     * @Route("/add", name="add")
     */
    public function addWish(Request $request, EntityManagerInterface $entityManager): Response
    {
        $wish = new Wish();
        $wish->setDateCreated(new \DateTime());

        $wishForm = $this->createForm(AddWishType::class, $wish);

        $wishForm->handleRequest($request);

        if ($wishForm->isSubmitted() && $wishForm->isValid()) {
            $entityManager->persist($wish);
            $entityManager->flush();

            $this->addFlash('success', 'Wish added! Now go do it.');
            return $this->redirectToRoute('wish_details', ['id' => $wish->getId()]);
        }

        return $this->render("wish/add.html.twig", [
            'wishForm' => $wishForm->createView()
        ]);
    }

    /**
     * @Route("/", name="list")
     */
    public function list(WishRepository $wishRepository): Response
    {
        $allWishes = $wishRepository->findAll();

        return $this->render('wish/list.html.twig', [
            'allWishes'=>$allWishes,
        ]);
    }

    /**
     * @Route("/details/{id}", name="details")
     */
    public function details(int $id, WishRepository $wishRepository): Response
    {
        $wish = $wishRepository->find($id);


        return $this->render('wish/details.html.twig', [
            "wish" => $wish
        ]);
    }
}
