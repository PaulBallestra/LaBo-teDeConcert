<?php
    //ROUTEUR DE L'ADMINISTRATEUR
    session_start(); //lancement de la session

    require '../helpers.php'; //on chope le helpers qui est dans le dossier parent

    //on vérifie bien qu'il est toujours admin et que ce n'est pas un user fantome
    if($_SESSION['user']['is_admin'] != 1 || !isset($_SESSION['user'])){
        header('Location: ../index.php'); //redirection vers la page d'accueil
        exit;
    }

    if (isset($_GET['page'])) {

        switch ($_GET['page']) {

            case 'categories': //si il veut afficher la gestion des catégories
                require 'controllers/categoryController.php';
                break;

            case 'products': //si il veut afficher la gestion des produits
                require 'controllers/productController.php';
                break;

            case 'users': //si il veut afficher la gestion des users
                require 'controllers/userController.php';
                break;

            default :
                require 'controllers/indexController.php';
                break;

        }

    }else
        require 'controllers/indexController.php';

    require 'views/layouts/admin.php'; //Require du layout de l'admin

    //Si il y a eu un message de généré en session, on le supprime
    if (isset($_SESSION['message']))
        unset($_SESSION['message']); //on supprime le flash session

    //Suppression des oldinputs du formulaire
    if (isset($_SESSION['old_inputs']))
        unset ($_SESSION['old_inputs']);
