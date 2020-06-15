<?php
    //ROUTEUR DE L'ADMINISTRATEUR
    require '../helpers.php'; //on chope le helpers qui est dans le dossier parent

    if (isset($_GET['controller'])):

        switch ($_GET['controller']):

            case 'labels':
                require 'controllers/labelController.php';
                break;

            default :
                require 'controllers/indexController.php';
                break;

        endswitch;

    else:
        require 'controllers/indexController.php';
    endif;

    require 'views/layouts/admin.php'; //Require du layout de l'admin

    //Si il y a eu un message de généré en session, on le supprime
    if (isset($_SESSION['message']))
        unset($_SESSION['message']); //on supprime le flash session

    //Suppression des oldinputs du formulaire
    if (isset($_SESSION['old_inputs']))
        unset ($_SESSION['old_inputs']);

