<?php

namespace App\Controller;

use App\Model\ItemManager;

class HomeController extends AbstractController
{
    /**
     * Display home page
     */
    public function index(): string
    {
        $itemManager = new ItemManager();
        $items = $itemManager->selectAll('title');

        return $this->twig->render('Home/index.html.twig', ['items' => $items]);
    }
}
