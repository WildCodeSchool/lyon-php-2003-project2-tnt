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
// Pour pouvoir se connecter depuis n'importe quelle page
// Fait office de UserController
// Form connexion = Nom + mdp , seul cas ou le sizeof($_POST) == 2
if (sizeof($_POST) === 2) {

    $pdo = new UserManager();

    if (isset($_POST['nickname'])) {
        $nickname = trim($_POST['nickname']);
        $infos = $pdo->selectOneByNickname($nickname);

    } elseif (isset($_POST['email'])) {
        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $email = $_POST['email'];
            $infos = $pdo->selectOneByEmail($email);
        }
    }

    if (isset($infos)) {
        $_SESSION['user'] = [
            'id' => $infos['id'],
            'nickname' => $infos['nickname']
        ];
    }
}

require_once __DIR__ . '/../src/routing.php';


//require_once '../vendor/autoload.php';  ???
