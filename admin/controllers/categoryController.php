<?php
    //CONTROLLER DES CATÉGORIES
    require 'models/Category.php';

    //si on a recu un parametre dans action
    if(isset($_GET['action'])){

        //en fonction de cette action
        switch($_GET['action']){

            case 'list': //affichage de toute les catégories

                $categories = getCategories();

                //on modifie la variable du nom de la page et de la view
                $title = "La Boîte de Concert - Gestion Catégories";
                $view = 'views/categories_list.php';
                break;

            default:
                //si il y a un problème dans l'url, on renvoit sur le dashboard
                header('Location: index.php');
                exit;
                break;

        }

    }else{

        //si il y a un problème dans le lien, on le renvoit vers le dashboard
        header('Location: index.php');
        exit;

    }