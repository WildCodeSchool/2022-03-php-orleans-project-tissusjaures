<?php

namespace App\Controller;

use App\Model\ClothCategoryManager;

class AdminClothCategoryController extends AbstractController
{
    public function index(): string
    {
        $clothCategoryList = new ClothCategoryManager();
        $clothCategories = $clothCategoryList->selectAll();

        return $this->twig->render('Admin/ClothCategory/index.html.twig', ['clothCategories' => $clothCategories]);
    }
}
