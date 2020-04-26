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
        $products = $productManager->selectAllProduct();

        return $this->twig->render('Product/listProduct.html.twig', ['products'=>$products]);
    }

    /**
     * Affiche la liste des service
     *
     */

    public function listService()
    {
        $productManager = new ProductManager();
        $products = $productManager->selectAllService();

        return $this->twig->render('Product/listService.html.twig', ['products'=>$products]);
    }


    /**
     * Display item creation page                 EN CONSTRUCTION
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    /*public function addService()
    {
        $productManager = new ProductManager();
        $listCategories = $productManager->selectAllCategories();


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product = [
                'title' => $_POST['title'],
                'category' => $_POST['category'],
                'image' => $_POST['image'],
                'description' => $_POST['description'],
                'exchange_type_id' => $_POST['title'],
            ];
            // $user_id recup avec $_SESSION
            // $product_type_id -> ici Service donc id en dur une fois défini
            $id = $productManager->insert($product, $user_id, $product_type_id);
            header('Location:/product/show/' . $id);
        }
        return $this->twig->render('Product/addService.html.twig', ['listeCategories' => $listCategories]);
    }*/

    /**
     * Display item creation page                 EN CONSTRUCTION
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    /*public function addGood()
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
    }*/

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
        return $this->twig->render('Product/rechercherBien.html.twig');
    }

    public function rechercherService(): string
    {
        if ($_GET) {
            $search = self::cleanInput($_GET['search']);
            $category = $_GET['category'];

            $productManager = new ProductManager();
            $listeServices = $productManager->searchService($search, $category);
            return $this->twig->render('Product/listService.html.twig', ['products' => $listeServices]);
        }
        return $this->twig->render('Product/rechercherService.html.twig');
    }
}
