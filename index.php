<?php

    //lancement de la session
    session_start();

    $_SESSION['cart'] = []; //Création du panier de la connexion de l'user

    require 'helpers.php'; //On require le helpers qui fait la connection avec la base de donnée

    //en fonction de la page on adapte le code
    if(isset($_GET['page'])):

        //En fonction du paramètre en url, on lance le controller adequat
        switch ($_GET['page']):

            case 'categories': //On appelle le controller de category
                require 'controllers/categoryController.php';
                break;

            case 'products': //on appelle le controller de product
                require 'controllers/productController.php';
                break;

            case 'register': //on appelle le controller de l'inscription
                require 'controllers/registerController.php';
                break;

            case 'login': //on appelle le controller du login
                require 'controllers/loginController.php';
                break;

            case 'logout': //si il se logout, on détruit la session et on redirige vers l'index

                $_SESSION['is_connected'] = 0; //on passe le flag de connexion a 0

                unset($_SESSION['user']); //on unset la session de l'user

                header('Location: index.php');
                exit;
                break;

            case 'profile': //appel du controller du profil
                require 'controllers/userController.php';
                break;

            default :
                require 'controllers/indexController.php';
                break;

        endswitch;

    else:
        require 'controllers/indexController.php';

    endif;

    //On require les layouts pour afficher le html sans se le taper sur chaque page
    require 'views/layouts/user.php';

    //Si il y a eu un message de généré en session, on le supprime
    if(isset($_SESSION['message']))
        unset($_SESSION['message']); //on supprime le flash session

    //Suppression des oldinputs du formulaire si il y en a
    if(isset($_SESSION['old_inputs']))
       unset ($_SESSION['old_inputs']);