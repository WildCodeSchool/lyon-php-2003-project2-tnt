<?php


namespace App\Controller;


class ProductController extends AbstractController
{
    /**
     * Affiche la liste des produits
     *
     */

    public function listProduct()
    {


        return $this->twig->render('Product/listProduct.html.twig');
    }
}