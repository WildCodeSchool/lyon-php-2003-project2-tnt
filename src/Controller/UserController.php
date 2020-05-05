<?php

namespace App\Controller;

use App\Model\UserManager;

class UserController extends AbstractController
{

    public function inscription()
    {
        if (!empty($_POST)) {
            $userManager = new UserManager();
            $nickname = self::cleanInput($_POST['nickname']);
            $email = self::cleanInput($_POST['email']);
            $pass = $_POST['pass'];

            $errors = [];

            if (empty($_POST['nickname'])) {
                $errors['nickname'] = "Nom / Pseudo requis";
            }
            if (empty($_POST['email'])) {
                $errors['email'] = "Email requis";
            }
            if (empty($_POST['pass'])) {
                $errors['pass'] = "Vérifiez vos mots de passe";
            }

            if ($userManager->selectOneByEmail($email)) {
                $errors['email'] = "Email déjà utilisé";
            }
            if ($userManager->selectOneByNickname($nickname)) {
                $errors['nickname'] = "Navré mais déjà pris !";
            }

            if (empty($errors)) {
                $pass = password_hash($pass, PASSWORD_DEFAULT);
                $infos = [
                    'nickname' => $nickname,
                    'email'    => $email,
                    'pass'     => $pass
                ];
                $id = $userManager->createProfil($infos);
                $_SESSION['user'] = [
                    'id'       => $id,
                    'nickname' => $nickname
                ];
                header('Location: /user/Profil/' . $id);
            }
            return $this->twig->render('User/inscription.html.twig', ['errors' => $errors]);
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
    public function profil($id)
    {
        $profilManager = new UserManager();
        $profil = $profilManager->selectOneById($id);
        return $this->twig->render('User/profil.html.twig', ['profil' => $profil]);
    }
}
