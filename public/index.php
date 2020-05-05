<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 14:01
 */

use App\Model\UserManager;

require_once __DIR__ . '/../vendor/autoload.php';

if (getenv('ENV') === false) {
    require_once __DIR__ . '/../config/debug.php';
    require_once __DIR__ . '/../config/db.php';
}
require_once __DIR__ . '/../config/config.php';
session_start();
if ($_POST) {
    $nickname = $email = $pass = '';
    $errors = [];

    if ($_POST['email']) {
        $email = trim($_POST['email']);
    }
    if ($_POST['nickname']) {
        $nickname = trim($_POST['nickname']);
    }
    $pass = $_POST['password'];

    if (empty($_POST['email']) || empty($_POST['nickname'])) {
        $errors['login'] = "Login requis";
    }
    if (empty($_POST['password'])) {
        $errors['pass'] = "Mot de passe requis";
    }

    if (empty($errors)) {
        $userManager = new UserManager();
        if (isset($_POST['nickname'])) {
            $user = $userManager->selectOneByNickname($nickname);
        } elseif (isset($_POST['email'])) {
            $user = $userManager->selectOneByEmail($email);
        }

        if (empty($user)) {
            $errors['login'] = "Login introuvable";
        } else {
            if ($pass == $user['password']) {
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'nickname' => $user['nickname']
                ];
                header('Location: ' . __DIR__);
            } else {
                $errors['pass'] = "Mauvais mot de passe";
            }
        }
//        return $this->twig->render();
    }
}
require_once __DIR__ . '/../src/routing.php';
