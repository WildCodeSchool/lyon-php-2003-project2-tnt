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

        return $this->twig->render('Product/listProduct.html.twig', ['products' => $products]);
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
            $title = AbstractController::testInput($_POST['title']);

            //$categoryId = 2;
            $description = (!empty($_POST['description'])) ? AbstractController::testInput($_POST['description']) : "";
            $proposition = (!empty($_POST['proposition'])) ? AbstractController::testInput($_POST['proposition']) : "";
            //$exchangeTypeId = (!empty($_POST['echange'])) ? $_POST['echange']= 1 : $_POST['echange'] = 2;
            $enEchangeDe = (!empty($_POST['enEchangeDe'])) ?  AbstractController::testInput($_POST['enEchangeDe']) : "";

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
}
