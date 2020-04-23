<?php

namespace App\Controller;

use App\Model\UserManager;

class UserController extends AbstractController
{

    public function inscription()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nickname = $email = $pass = '';
            $errors = [];

            if (!empty($_POST['nickname'])) {
                $nickname = AbstractController::testInput($_POST['pseudo']);
            } else {
                $errors['nickname'] = "Nom / Pseudo requis";
            }
            if (!empty($_POST['mail'])) {
                if (filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
                    $email = $_POST['mail'];
                } else {
                    $errors['mail'] = "Format invalide";
                }
            } else {
                $errors['email'] = "Email requis";
            }
            if (!empty($_POST['pass']) && !empty($_POST['pass2'])) {
                if ($_POST['pass'] === $_POST['pass2']) {
                    $pass = AbstractController::testInput($_POST['pass']);
                } else {
                    $errors['pass'] = "Les mots de passe doivent correspondre";
                }
            } else {
                $errors['pass'] = "Mot de passe requis";
            }

            if (empty($errors)) {
                $userManager = new UserManager();
                $infos = [
                    'nickname' => $nickname,
                    'email' => $email,
                    'pass' => $pass
                ];
                $id = $userManager->createProfil($infos);
                header('Location:/User/profil/' . $id);
            }
        }
        return $this->twig->render('User/inscription.html.twig');
    }

//    public function inventaire($id)
//    {
//        // select inventaire.user_id
//        return $this->twig->render('User/inventaire.html.twig');
//    }
//
//    public function favoris($id)
//    {
//        // select favoris.user_id
//        return $this->twig->render('User/favoris.html.twig');
//    }
//
//    public function preferences($id)
//    {
//        // select preferences.user_id
//        return $this->twig->render('User/preferences.html.twig');
//    }
//
//    public function profil($id)
//    {
//        // select user profil
//        return $this->twig->render('User/profil.html.twig');
//    }
}
