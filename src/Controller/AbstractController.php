<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 15:38
 * PHP version 7
 */

namespace App\Controller;

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

/**
 *
 */
abstract class AbstractController
{
    /**
     * @var Environment
     */
    protected $twig;


    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        $loader = new FilesystemLoader(APP_VIEW_PATH);
        $this->twig = new Environment(
            $loader,
            [
                'cache' => !APP_DEV,
                'debug' => APP_DEV,
            ]
        );
        $this->twig->addExtension(new DebugExtension());
        $this->twig->addGlobal('session', $_SESSION);
        $this->twig->addGlobal('url', $_SERVER['PHP_SELF']);
    }

    protected static function cleanInput($data) : string
    {
        $data = trim($data);              // Strip unnecessary characters
        $data = stripslashes($data);      // Remove backslashes (\)
        $data = htmlspecialchars($data);  // converts special characters to HTML
        return $data;
    }

    protected static function checkErrors(array $requis) : array
    {
        $errors = [];

        if ($requis[0] == '') {
            $errors['title'] = "Veuillez renseigner un titre valide svp";
        }
        if ($requis[1] == '') {
            $errors['description'] = "Une courte description serait la bienvenue";
        }
        if ($requis[2] == '2' && $requis[3] == '' && $requis[4] == 'pasOuvert') {
            $errors['echange']="Si vous souhaitez procéder à un échange, cocher la case Ouvert.e à toutes propositions 
                               ou veuillez renseigner les biens / services que vous aimeriez en retour le cas écheant ";
        }
        return $errors;
    }

    protected static function checkFile(array $files)
    {
        $errors = [];

        $allowedExt = array('jpg', 'png', 'gif', 'jpeg');
        $fileType = explode('/', $files['type']);
        $fileExt = end($fileType);

        if ($files['size'] > 1000000) {
            $errors['size'] = "File must not exceed 1Mo";
        } elseif (!empty($files['error'])) {
            $errors['code'] = "Upload failed";
        } elseif (!in_array($fileExt, $allowedExt)) {
            $errors['ext'] = "file extension" . $fileExt . " is not allowed.";
        }
        return $errors;
    }
}
