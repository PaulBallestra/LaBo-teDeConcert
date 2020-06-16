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
                if(!isset($_GET['id'])){
                    $_SESSION['message'] = 'Aucune catégorie de ce type.';

                    header('Location: index.php');
                    exit;
                }

                //si l'id n'est pas de type number, on renvoit sur l'accueil
                if(!ctype_digit($_GET['id'])){
                    $_SESSION['message'] = 'L\'id n\'est pas valide.';

                    header('Location: index.php');
                    exit;
                }

                //si l'id n'existe pas en bd, on renvoit sur l'accueil
                if(!checkCategoryExists($_GET['id'])){
                    $_SESSION['message'] = 'Cette catégorie n\'existe pas.';

                    header('Location: index.php');
                    exit;
                }

                //sinon on affiche la page de la catégorie spécifique
                $category = getCategory($_GET['id']);
                $productsInCategory = getProductsByCategory($_GET['id']); //on chope tous les produits contenu dans une catégorie

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
