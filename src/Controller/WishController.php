<?php

namespace App\Controller;

use App\Services\Censorship;
use App\Entity\Wish;
use App\Form\AddWishType;
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
     * @Route("/", name="list")
     */
    public function list(WishRepository $wishRepository): Response
    {
        $allWishes = $wishRepository->findAllPublishable();

        return $this->render('wish/list.html.twig', [
            'allWishes'=>$allWishes,
        ]);
    }

    /**
     * @Route("/listCategory/{categoryId}", name="listCategory")
     */
    public function listByCategory(int $categoryId ,WishRepository $wishRepository): Response
    {
        $allWishesByCategory = $wishRepository->findByCategory($categoryId);

        return $this->render('wish/listCategory.html.twig', [
            "allWishesByCategory" => $allWishesByCategory
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

    /**
     * @Route("/add", name="add")
     */
    public function addWish(
        Request $request,
        EntityManagerInterface $entityManager,
        Censorship $censorship
    ): Response
    {
        $wish = new Wish();

        $wishForm = $this->createForm(AddWishType::class, $wish);

        $wishForm->handleRequest($request);

        if ($wishForm->isSubmitted() && $wishForm->isValid()) {
            $wish->setDateCreated(new \DateTime());

            $purifyString = $censorship->purify($wish->getTitle());
            $wish->setTitle($purifyString);
            $purifyString = $censorship->purify($wish->getDescription());
            $wish->setDescription($purifyString);

            $entityManager->persist($wish);
            $entityManager->flush();

            $this->addFlash('success', 'Wish added! Now go do it.');
            return $this->redirectToRoute('wish_details', ['id' => $wish->getId()]);
        }

        return $this->render("wish/add.html.twig", [
            'wishForm' => $wishForm->createView(),
        ]);
    }
}
