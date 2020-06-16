<?php
    //CONTROLLER DES PRODUITS
    require 'models/Product.php';

    //si on a recu un parametre dans action
    if(isset($_GET['action'])){

        //en fonction de cette action
        switch($_GET['action']){

            case 'list': //affichage de toute les produits

                $products = getProducts();

                //on modifie la variable du nom de la page et de la view
                $title = "La Boîte de Concert - Gestion Produits";
                $view = 'views/products_list.php';
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
