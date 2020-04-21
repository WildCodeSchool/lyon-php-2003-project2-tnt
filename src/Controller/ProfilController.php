<?php

namespace App\Controller;

use App\Model\ProductManager;

class ProfilController extends AbstractController
{
    public function inscription()
    {
        return $this->twig->render('Profil/inscription.html.twig');
    }
}
