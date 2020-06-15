<?php

    require 'models/Category.php';
    require 'models/Product.php';
    require 'models/Address.php';

    if(isset($_GET['action'])){

        switch($_GET['action']){

            case 'list': //Pour l'affichage de toutes les catégories
                $categories = getCategories(); //on récupère toutes les catégories

                $title = "La Boîte de Concert - Catégories";
                $view = 'views/category_list.php';
                break;

            case 'display':

                //si l'id n'est pas set, on renvoit sur l'accueil
                if(!isset($_GET['id']) || !ctype_digit($_GET['id'])){
                    header('Location: index.php');
                    exit;
                }

                $category = getCategory($_GET['id']);
                $productsInCategory = getProductsByCategory($_GET['id']); //on

                $title = "La Boîte de Concert - " . $category['name'];
                $view = 'views/category_unique.php';

                break;

            default: //redirection si il y a un problème
                $categories = getCategories(); //on récupère toutes les catégories
                $title = "La Boîte de Concert - Catégories";
                $view = 'views/category_list.php';
                break;
        }
    }else{ //redirection vers l'accueil en cas de modification de l'url
        header('Location: index.php');
        exit;
    }
