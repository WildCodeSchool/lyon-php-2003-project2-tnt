<?php

namespace App\Controller;

use App\Model\CategoryManager;
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
        $products = $productManager->selectAllProduct();

        return $this->twig->render('Product/listProduct.html.twig', ['products' => $products]);
    }

    /**
     * Affiche la liste des service
     *
     */

    public function listService()
    {
        $productManager = new ProductManager();
        $products = $productManager->selectAllService();

        return $this->twig->render('Product/listService.html.twig', ['products' => $products]);
    }

    /**
     * Display item creation page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function addService()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productManager = new ProductManager();
            $product = [
                'title' => $_POST['title'],
            ];
            $id = $productManager->insert($product);
            header('Location:/product/show/' . $id);
        }
        return $this->twig->render('Product/addService.html.twig');
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
    }

    /**
     * Display Bien ou Service
     * joue un rôle de 'routeur'
     *
     *
     * @param string $var
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function bienOuService(string $var)
    {
        return $this->twig->render('Product/bien_ou_service.html.twig', ['var' => $var]);
    }

    /**
     * Display validation form après ajout annonce
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function validation()
    {
        return $this->twig->render('Product/validation.html.twig');
    }

    public function rechercherBien(): string
    {
        $categoryManager = new CategoryManager();
        $category = $categoryManager->selectAllCategory();

        if ($_GET) {
            $search = self::testInput($_GET['search']);
            $category = $_GET['category'];

            $productManager = new ProductManager();
            $listeBien = $productManager->searchService($search, $category);
            return $this->twig->render('Product/listService.html.twig', ['products' => $listeBien]);
        }
        return $this->twig->render('Product/rechercherBien.html.twig', ['category' => $category]);
    }

    public function rechercherService(): string
    {
        return $this->twig->render('Product/rechercherService.html.twig');
    }
}
