<?php

namespace App\Controller;

use App\Model\CategoryManager;

class CategoryController extends AbstractController
{
    public function listProduct()
    {
        $categoryManager = new CategoryManager();
        $category = $categoryManager->selectAllCategory();

        return $this->twig->render('Product/listProduct.html.twig', ['category' => $category]);
    }
}