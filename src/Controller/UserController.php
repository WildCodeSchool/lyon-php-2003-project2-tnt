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
            $zipCode = self::cleanInput($_POST['zipCode']);
            $pass = $_POST['pass'];

            $errors = self::checkIfEmpty([$_POST['nickname'],$_POST['email'],$_POST['pass'],$_POST['zipCode']]);

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
                    'pass' => $pass,
                    'zipCode' => $zipCode
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

    /**
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function edit(int $id):string
    {
        $userManager = new UserManager();
        $user = $userManager->selectUserById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user['lastname'] = self::cleanInput($_POST['lastname']);
            $user['firstname'] = self::cleanInput($_POST['firstname']);
            $user['email'] = self::cleanInput($_POST['email']);
            $user['phone'] = self::cleanInput($_POST['phone']);
            $user['zip_code'] = self::cleanInput($_POST['zip_code']);

            $userManager->update($user);
            header("Location:/User/profil/$id");
        }
        return $this->twig->render('User/edit.html.twig', ['user' => $user]);
    }
//

    /**
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function profil(int $id):string
    {
        $userManager = new UserManager();
        $user = $userManager->selectOneById($id);

        $inventaireManager = new UserManager();
        $inventaire = $inventaireManager->userProduct($id);

        $display_modal = false;
        if (isset($_SERVER['HTTP_REFERER'])) {
            if ($_SERVER['HTTP_REFERER'] == 'http://localhost:8000/user/inscription') {
                $display_modal = true;
            }
        }

        return $this->twig->render('User/profil.html.twig', ['user' => $user, 'inventaire' => $inventaire, 'display_modal' => $display_modal]);
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
                    if (password_verify($pass, $user['password'])) {
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

    public static function checkIfEmpty(array $toCheck) : array
    {
        $errors = [];
        if (empty($toCheck[0])) {
            $errors['nickname'] = "Nom / Pseudo requis";
        }
        if (empty($toCheck[1])) {
            $errors['email'] = "Email requis";
        }
        if (empty($toCheck[2])) {
            $errors['pass'] = "Vérifiez vos mots de passe";
        }
        if (empty($toCheck[3])) {
            $errors['zipCode'] = "Veuillez renseigner un code postal à 5 chiffres svp";
        }
        return $errors;
    }
}
