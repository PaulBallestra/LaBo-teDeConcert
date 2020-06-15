<?php

    require_once ('models/Category.php');

    if(isset($_GET['action'])){

        switch($_GET['action']){

            case 'list': //Pour l'affichage de toutes les catégories
                $categories = getCategories(); //on récupère toutes les catégories

                $title = "La Boîte de Concert - Catégories";
                $view = 'views/category.php';

                break;

            default:
                $categories = getCategories(); //on récupère toutes les catégories
                $title = "La Boîte de Concert - Catégories";
                $view = 'views/category.php';
                break;
        }
    }else{
        header('Location: index.php');
        exit;
    }
