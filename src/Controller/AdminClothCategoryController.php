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

    // public function editClothCategory($id): string
    // {
    //     $categoryErrors = [];
    //     $imageErrors = [];

    //     $clothCategoryList = new ClothCategoryManager();
    //     $clothCategories = $clothCategoryList->selectOneById($id);

    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $clothCategories = array_map('trim', $_POST);
    //         $clothCategories['id'] = $id;

    //         $categoryErrors = $this->clothCategoryValidate($clothCategoryList);

    //         $imageFile = $_FILES['image'];
    //         $imageErrors = $this->validateImage($imageFile);

    //         if (empty($categoryErrors) && empty($imageErrors)) {
    //             $extension = pathinfo($imageFile['name'], PATHINFO_EXTENSION);
    //             $imageName = uniqid('', true) . '.' . $extension;

    //             move_uploaded_file($imageFile['tmp_name'], UPLOAD_PATH . '/' . $imageName);

    //             $clothCategoryManager = new ClothCategoryManager();
    //             $clothCategoryList['image'] = $imageName;
    //             $clothCategoryList->update($clothCategories);
    //             header('Location: /admin/categories-tissus/');
    //         }
    //     }
    //     return $this->twig->render('Admin/ClothCategory/add.html.twig', [
    //         'categoryErrors' => $categoryErrors,
    //         'imageErrors' => $imageErrors,
    //     ]);
    // }
}
