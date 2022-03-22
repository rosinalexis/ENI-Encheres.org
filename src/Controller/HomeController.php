<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ItemRepository $itemRepository, CategoryRepository $categoryRepo): Response
    {

        $soldItems = $itemRepository->findAllSoldItems();
        $lstCategory = $categoryRepo->findAll();

        return $this->render('home/index.html.twig', [
            'soldItems' => $soldItems,
            'lstCategory' => $lstCategory
        ]);
    }
}
