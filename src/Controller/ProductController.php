<?php

namespace App\Controller;

use App\Model\ProductManager;

/**
 * Class ProductController
 *
 */
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
    
    /**
     * Display item creation page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function addGood()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productManager = new ProductManager();
            $product = [
                'title' => $_POST['title'],
            ];
            $id = $productManager->insert($product);
            header('Location:/product/show/' . $id);
        }
        return $this->twig->render('Product/addGood.html.twig');
      
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
