<?php

namespace App\Controller;

use App\Model\ProductManager;

class ProductController extends AbstractController
{
    /**
     * Ajouter Bien ou Service      EN CONSTRUCTION
     *
     *
     */
    public function add($bienService)
    {
        $productManager = new ProductManager();
        $listCategories = $productManager->selectAllCategories();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = self::cleanInput($_POST['title']);
            $description = self::cleanInput($_POST['description']);

            $errors = self::checkErrors([$title,$description,$_POST['echangeOuDon'],
                                         $_POST['enEchangeDe'],$_POST['proposition']]);
            if (!empty($errors)) {
                return $this->twig->render('Product/addService.html.twig', ['listeCategories' => $listCategories,
                                                                                  'errors' => $errors]);
            }

            $product = [
                'title' => $title,
                'category' => $_POST['category'],
                'etat' => $_POST['etat'],
                'image' => $_POST['image'],
                'description' => $description,
                'exchange_type_id' => $_POST['echangeOuDon'],
                'wantBack' => self::cleanInput($_POST['enEchangeDe']),
                'fullProp' => $_POST['proposition'],
            ];
            $userId = $_SESSION['user']['id'];
            $id = $productManager->insert($product, $userId, $bienService);
            header('Location:/product/show/' . $id);
        }
        return $this->twig->render('Product/addService.html.twig', ['listeCategories' => $listCategories]);
    }

    /**
     * Display Bien ou Service
     * joue un rôle de 'routeur'
     *
     *
     * @param string $var
     * @return string
     */
    public function bienOuService(string $var)
    {
        return $this->twig->render('Product/bien_ou_service.html.twig', ['var' => $var]);
    }

    /**
     * Display validation form après ajout annonce
     *
     * @return string
     */
    public function validation()
    {
        return $this->twig->render('Product/validation.html.twig');
    }

    /**
     * Affiche la liste des biens OU des services OU de notre recherche
     * Notre recherche se fait à partir d'une des listes
     * (affichage de la liste avec input (Rechercher) + filtre (catégorie)
     *
     * @param string $what
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function show(string $what)
    {
        $productManager = new ProductManager();
        $productType = -1;

        switch ($what) {
            case 'listService':
                $productType = 2;
                $products = $productManager->selectAll(2);
                return $this->twig->render('Product/show.html.twig', ['products' => $products]);
            case 'listProduct':
                $productType = 1;
                $products = $productManager->selectAll(1);
                return $this->twig->render('Product/show.html.twig', ['products' => $products]);
            default: // ... error 404 not found
        }

        if ($_GET) {
            $search = self::cleanInput($_GET['search']);
            $category = $_GET['category'];
            $products = $productManager->search($search, $category, $productType);
            return $this->twig->render('Product/show.html.twig', ['products' => $products]);
        }
    }
}
