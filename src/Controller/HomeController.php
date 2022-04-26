<?php

namespace App\Controller;

use App\Model\HomeClothManager;
use App\Model\HomeMachineManager;

class HomeController extends AbstractController
{
    /**
     * Display home page
     */
    public function index(): string
    {
        $homeClothManager = new HomeClothManager();
        $newClothes = $homeClothManager->selectByIsNew();
        $homeMachineManager = new HomeMachineManager();
        $newMachines = $homeMachineManager->selectByIsNew();

        return $this->twig->render('Home/index.html.twig', ['clothes' => $newClothes, 'machines' => $newMachines]);
    }
}
