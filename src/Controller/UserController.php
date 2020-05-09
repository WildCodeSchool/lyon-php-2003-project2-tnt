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
                    'email' => $email,
                    'pass' => $pass
                ];
                $id = $userManager->createProfil($infos);
                $_SESSION['user'] = [
                    'id' => $id,
                    'nickname' => $nickname,
                    'email' => $email
                ];
                header('Location: /user/Profil/' . $id);
            }
            return $this->twig->render('User/inscription.html.twig', ['errors' => $errors]);
        }
        return $this->twig->render('User/inscription.html.twig');
    }

    public function inventaire($id)
    {
        $inventaireManager = new UserManager();
        $inventaire = $inventaireManager->userProduct($id);

        return $this->twig->render('User/inventaire.html.twig', ['inventaire' => $inventaire]);
    }

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

    public function login()
    {
        if ($_POST) {
            $nickname = $email = $pass = '';
            $errors = [];

            $email = trim($_POST['email']);
            $nickname = trim($_POST['nickname']);
            $pass = $_POST['password'];

            if (empty($nickname) && empty($email)) {
                $errors['login'] = "Login requis";
            }
            if (empty($pass)) {
                $errors['pass'] = "Mot de passe requis";
            }

            if (empty($errors)) {
                $userManager = new UserManager();
                if ($email == '') {
                    $user = $userManager->selectOneByNickname($nickname);
                } else {
                    $user = $userManager->selectOneByEmail($email);
                }
                if (empty($user)) {
                    $errors['login'] = "Login introuvable";
                } else {
                    if ($pass == $user['password']) {
                        $_SESSION['user'] = [
                            'id' => $user['id'],
                            'nickname' => $user['nickname'],
                            'email' => $user['email']
                        ];
                        header('Location: /');
                    } else {
                        $errors['pass'] = "Mauvais mot de passe";
                    }
                }
            }
            return $this->twig->render('User/login.html.twig', ['errors' => $errors]);
        }
        return $this->twig->render('User/login.html.twig');
    }

    public function logout()
    {
        unset($_SESSION['user']);
        header('Location: /');
    }
}
