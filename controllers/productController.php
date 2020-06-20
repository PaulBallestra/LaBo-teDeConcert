<?php

    require 'models/Product.php';
    require 'models/Address.php';
    require 'models/Cart.php';

    if(isset($_GET['action'])){

        switch($_GET['action']){

            case 'list': //Pour l'affichage de toutes les catégories

                //Si l'user veut les afficher par ... (alors il y a by dans l'url)
                if(isset($_GET['by'])){
                    //en fonction du parametre on adapte la fonction
                    switch($_GET['by']){
                        case 'name':
                            $products = getProducts(); //on chope tous les produits par ordre  alphabétique (ordre de base)
                            break;

                        case 'capacity':
                            $products = getProductsByCapacity();
                            break;

                        case 'town':
                            $products = getProductsByTown();
                            break;

                        default:
                            $products = getProducts();
                            break;
                    }

                }else //sinon on affiche la liste triée par ordre alphabétique
                    $products = getProducts(); //on récupère tous les produits


                $title = 'La Boîte de Concert - Produits';
                $view = 'views/product_list.php';

                break;

            case 'display': //pour l'affichage unique d'un produit en fonction de son id

                //si l'id n'est pas set, on renvoit sur l'accueil
                if(!isset($_GET['id'])){
                    $_SESSION['message'] = 'Aucun produit de ce type.';

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
                if(!checkProductExists($_GET['id'])){
                    $_SESSION['message'] = 'Ce produit n\'existe pas.';

                    header('Location: index.php');
                    exit;
                }

                //on stocke l'unique produit
                $product = getProduct($_GET['id']);
                $productImages = explode(',', $product['images']);
                $productAddress = getAddress($_GET['id'], false); //on chope également son adresse

                $title = 'La Boîte de Concert - ' . $product['name'];
                $view = 'views/product_unique.php';
                break;

            case 'add': //dans le cas ou l'user veut ajouter un produit a son panier

                //on vérifie si l'user est connecté avant de l'ajouter au panier
                if(!isset($_SESSION['user'])){
                    //Si ce n'est pas le cas, on l'envoit sur la page d'inscription
                    $_SESSION['message'] = 'Veuillez vous créer un compte pour faire ceci.';

                    header ('Location: index.php?page=register');
                    exit;
                }

                //si l'id n'est pas set, on renvoit sur l'accueil
                if(!isset($_GET['id'])){
                    $_SESSION['message'] = 'Aucun produit de ce type.';

                    $products = getProducts(); //on récupère tous les produits

                    header('Location: index.php?page=products&action=list'); //si ce n'est pas le cas, on le renvoit sur la page des produits
                    exit;
                }

                //si l'id n'est pas de type number, on renvoit sur l'accueil
                if(!ctype_digit($_GET['id'])){
                    $_SESSION['message'] = 'L\'id n\'est pas valide.';

                    $products = getProducts(); //on récupère tous les produits

                    header('Location: index.php?page=products&action=list'); //si ce n'est pas le cas, on le renvoit sur la page des produits
                    exit;
                }

                //on vérifie que le produit existe
                if(!checkProductExists($_GET['id'])){
                    $_SESSION['message'] = 'Aucun produit correspondant.';

                    $products = getProducts(); //on récupère tous les produits

                    header('Location: index.php?page=products&action=list'); //si ce n'est pas le cas, on le renvoit sur la page des produits
                    exit;
                }

                //On vérifie qu'il n'a pas déjà ce produit
                if(!empty(checkProductInCart($_GET['id'], getIdCartOfUser($_SESSION['user']['id'])))){
                    //si c'est le cas, il ne peut pas
                    //redirection vers la page des produits
                    $products = getProducts(); //on récupère tous les produits

                    //affichage du message comme quoi le produit a été ajouté
                    $_SESSION['message'] = 'Vous ne pouvez pas ajouter 2 fois ce produit.';

                    header('Location: index.php?page=products&action=list');
                    exit;
                }

                //sinon on l'ajoute au panier
                addProductInCart($_GET['id'], getIdCartOfUser($_SESSION['user']['id']));

                //en sauvegardant les infos nécessaires
                $product = getProduct($_GET['id']);
                $productAddress = getAddress($_GET['id'], false); //on chope également son adresse

                $_SESSION['user']['cart'][] = [
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'addressNumber' => $productAddress['number'],
                    'addressStreet' => $productAddress['street'],
                    'addressTown' => $productAddress['town'],
                    'addressPostalCode' => $productAddress['postal_code'],
                    'addressCountry' => $productAddress['country'],
                    'quantity' => 1
                ];

                //redirection vers la page des produits
                $products = getProducts(); //on récupère tous les produits

                //affichage du message comme quoi le produit a été ajouté
                $_SESSION['message'] = 'Le produit a bien été enregistré dans votre <a style="color: black;" href="' . htmlspecialchars("index.php?page=profile") . '"> panier </a> !';

                $title = 'La Boîte de Concert - Produits';
                $view = 'views/product_list.php';
                break;

            case 'search': //dans le cas ou il veut rechercher un produit

                $informations = $_POST;

                if(!isset($informations['search']) && !empty($informations['search'])){
                    //Si ce n'est pas le cas, on l'envoit sur la page d'inscription
                    $_SESSION['message'] = 'Votre recherche est erronée.';

                    $products = getProducts(); //on récupère tous les produits

                    header ('Location: index.php?page=products&action=list');
                    exit;
                }else{
                    $_SESSION['search'] = $informations['search'];
                }
                
                $products = getProductsBySearch($_SESSION['search']);

                $title = "La Boîte de Concert - Recherche";
                $view = 'views/product_list.php';

                break;

            default:
                $products = getProducts();

                $title = 'La Boîte de Concert - Produits';
                $view = 'views/product_list.php';
                break;

        }
    }else{
        header('Location: index.php');
        exit;
    }