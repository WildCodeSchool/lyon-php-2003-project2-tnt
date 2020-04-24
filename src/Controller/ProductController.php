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

        return $this->twig->render('Product/listService.html.twig', ['products'=>$products]);
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
        $title = $categoryId = $exchangeTypeId = $description  = $proposition = $enEchangeDe = '';
        $errors =[];
        if (($_SERVER['REQUEST_METHOD'] === 'POST') && (!empty($_POST))) {
            $title = AbstractController::cleanInput($_POST['title']);

            //$categoryId = 2;
            $description = (!empty($_POST['description'])) ? AbstractController::cleanInput($_POST['description']) : "";
            $proposition = (!empty($_POST['proposition'])) ? AbstractController::cleanInput($_POST['proposition']) : "";
            //$exchangeTypeId = (!empty($_POST['echange'])) ? $_POST['echange']= 1 : $_POST['echange'] = 2;
            $enEchangeDe = (!empty($_POST['enEchangeDe'])) ? AbstractController::cleanInput($_POST['enEchangeDe']) : "";

            if (empty($_POST['title'])) {
                $errors['title'] = "Que souhaitez vous proposer?";
            }
            if (empty($_POST['category_id'])) {
                $errors['category_id'] = "Renseignez une catégorie";
            }
            if (empty($errors)) {
                $productManager = new ProductManager();
                $product = [
                    'user_id' => 1,
                    'product_type_id' => 1,
                    'title' => $title,
                    'category_id' => $categoryId,
                    'description' => $description,
                    'exchange_type_id' => $exchangeTypeId,
                    'proposition' => $proposition,
                    'enEchangeDe' => $enEchangeDe
                ];
                $id = $productManager->insert($product);
                header('Location:/product/show/' . $id);
            }
        }
        return $this->twig->render('Product/addService.html.twig', ['errors' => $errors]);
    }

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
