<?php

namespace App\Controller;

use App\Model\ProductManager;
use DateTime;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

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
        $productType = (($bienService == 'service') ? 2 : 1);


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = self::cleanInput($_POST['title']);
            $description = self::cleanInput($_POST['description']);

            $errors = self::checkErrors([$title,$description,$_POST['echangeOuDon'],
                                         $_POST['enEchangeDe'],$_POST['proposition']]);
            if (!empty($errors)) {
                return $this->twig->render('Product/add.html.twig', ['categories' => $listCategories,
                                                                           'errors' => $errors, 'var' => $bienService]);
            }

            $etat = ((isset($_POST['etat'])) ? $_POST['etat'] : 'null');

            $exchange = (($_POST['echangeOuDon'] == 'echange') ? 2 : 1);
            $product = [
                'title' => $title,
                'category_id' => 1,
                'etat' => $etat,
                'description' => $description,
                'exchange_type_id' => $exchange,
                'wantBack' => self::cleanInput($_POST['enEchangeDe']),
                'fullProp' => $_POST['proposition'],
            ];
            $userId = $_SESSION['user']['id'];
            $productManager->insert($product, $userId, $productType);
            header('Location:/product/show/' . $bienService);
        }
        return $this->twig->render('Product/add.html.twig', ['categories' => $listCategories,
                                                                    'var' => $bienService]);
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
     * (affichage de la liste + input(Rechercher) + filtre(catégorie)
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
        $productType = (($what == 'service') ? 2 : 1);

        $products = $productManager->selectAll($productType);
        $categories = $productManager->selectAllCategories();

        if ($_GET) {
            $search = self::cleanInput($_GET['search']);
            $category = $_GET['category'];
            $products = $productManager->search($search, $category, $productType);
            return $this->twig->render('Product/show.html.twig', ['products' => $products,
                                                                        'var' => "mySearch",
                                                                        'categories' => $categories]);
        }
        return $this->twig->render('Product/show.html.twig', ['products' => $products,
                                                                    'var' => $what,
                                                                    'categories' => $categories]);
    }

    public function details(string $productId)
    {
        $manager = new ProductManager();
        $details = $manager->getDetails($productId);

//        try {
            return $this->twig->render('Product/details.html.twig', ['details' => $details, 'id' => $productId]);
//        } catch (LoaderError $e) {
//        } catch (RuntimeError $e) {
//        } catch (SyntaxError $e) {
//        }
    }

    public function offre($productId)
    {
        $manager = new ProductManager();
        $details = $manager->getDetails($productId);

        return $this->twig->render('Product/offre.html.twig', ['details' => $details]);
    }

    public function showProduct()
    {

        return $this->twig->render('Item/show.html.twig');
    }

    /**
     * Handle item deletion
     * @param int $idProduct
     */
    public function deleteProduct(int $idProduct)
    {
        $deleteProduct = new ProductManager();
        $user = $deleteProduct->userId($idProduct);
        $deleteProduct->delete($idProduct);

        header('Location: /user/inventaire/' . $user['user_id']);
    }
}
