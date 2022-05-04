<?php

namespace App\Controller;

use App\Model\ClothManager;
use App\Model\MachineManager;

class HomeController extends AbstractController
{
    /**
     * Display home page
     */
    public function index(): string
    {
        $homeClothManager = new ClothManager();
        $newClothes = $homeClothManager->selectByIsNew();
        $homeMachineManager = new MachineManager();
        $newMachines = $homeMachineManager->selectByIsNew();

        return $this->twig->render('Home/index.html.twig', ['clothes' => $newClothes, 'machines' => $newMachines]);
    }
}
