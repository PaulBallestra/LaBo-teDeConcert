<?php

    //lancement de la session
    session_start();

    $_SESSION['cart'] = []; //Création du panier des la connexion de l'user

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

            case 'profile':
                require 'controllers/userController.php';
                break;

                /* Dans le cas ou l'user est admin et qu'il veut aller dans la gestion d'admin */
            case 'admin':

                //si un user non admin veut atteindre la page d'admin, on le renvoit sur l'index
                if($_SESSION['user']['is_admin'] != 1)
                    require 'controllers/indexController.php';
                else{
                    require 'admin/index.php';
                }
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