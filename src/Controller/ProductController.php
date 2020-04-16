<?php

namespace App\Controller;

use App\Model\ProductManager;

class ProductController extends AbstractController
{
    /**
     * Affiche la liste des produits
     *
     */

    public function listProduct()
    {
        $productManager = new ProductManager();
        $products = $productManager->selectAll();

        return $this->twig->render('Product/listProduct.html.twig', ['products'=>$products]);
    }
}
