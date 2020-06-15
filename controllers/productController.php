<?php

    require ('models/Product.php');
    require ('models/Address.php');

    if(isset($_GET['action'])){

        switch($_GET['action']){

            case 'list': //Pour l'affichage de toutes les catégories
                $products = getProducts(); //on récupère toutes les catégories

                $title = 'La Boîte de Concert - Produits';
                $view = 'views/product.php';

                break;

            case 'display': //pour l'affichage unique d'un produit en fonction de son id

                //si l'id n'est pas set, on renvoit sur l'accueil
                if(!isset($_GET['id']) || !ctype_digit($_GET['id'])){
                    header('Location: index.php');
                    exit;
                }

                //on stocke l'unique produit
                $product = getProduct($_GET['id']);
                $productAddress = getAddress($_GET['id'], false); //on chope également son adresse

                $title = 'La Boîte de Concert - ' . $product['name'];
                $view = 'views/product_unique.php';
                break;

            default:
                $title = 'La Boîte de Concert - Accueil';
                $view = 'views/index.php';
                break;

        }
    }else{
        header('Location: index.php');
        exit;
    }