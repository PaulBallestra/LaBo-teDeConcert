<?php

    require_once ('models/Product.php');

    if(isset($_GET['action'])){

        switch($_GET['action']){

            case 'list': //Pour l'affichage de toutes les catégories
                $products = getProducts(); //on récupère toutes les catégories

                $title = 'La Boîte de Concert - Produits';
                $view = 'views/product.php';

                break;
        }
    }