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
}
