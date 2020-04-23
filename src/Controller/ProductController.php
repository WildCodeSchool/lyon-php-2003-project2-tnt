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
            $title = $category = $subCategory = $etat = $description = $don = $echange = $proposition = '';
            $errors =[];
            if (!empty($_POST['title'])) {
                $title = AbstractController::testInput($_POST['title']);
            } else {
                $errors['title'] = "Que souhaitez vous proposer?";
            }
            if (!empty($_POST['category'])) {
                $category = AbstractController::testInput($_POST['category']);
            } else {
                $errors['category'] = "Renseignez une catégorie";
            }
            if (!empty($_POST['subCategory'])) {
                $subCategory = AbstractController::testInput($_POST['subCategory']);
            }
            if (!empty($_POST['etat'])) {
                $etat = AbstractController::testInput($_POST['etat']);
            } else {
                $errors['etat'] = "Précisez l'état";
            }
            if (!empty($_POST['description'])) {
                $description = AbstractController::testInput($_POST['description']);
            } else {
                $errors['descritpion'] = "Renseignez d'avantage d'information";
            }

            if (!empty($_POST['don'])) {
                $don = $_POST['don'];
            }
            if (!empty($_POST['echange'])) {
                $echange = AbstractController::testInput($_POST['proposition']);
            }
            if (!empty($_POST['proposition'])) {
                $proposition = AbstractController::testInput($_POST['proposition']);
            }
            if (empty($errors)) {
                $productManager = new ProductManager();
                $product=[
                    'title' => $title,
                    'category' => $category,
                    'subCategory' => $subCategory,
                    'etat' => $etat,
                    'description' => $description,
                    'don' => $don,
                    'echange' => $echange,
                    'proposition' => $proposition
                ];
            }

            $id = $productManager->insertProduct($product);
            header('Location:/product/advertGood/' . $id);
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
        return $this->twig->render('Product/rechercherService.html.twig');
    }
}
