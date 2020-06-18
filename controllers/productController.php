<?php

    require ('models/Product.php');
    require ('models/Address.php');

    if(isset($_GET['action'])){

        switch($_GET['action']){

            case 'list': //Pour l'affichage de toutes les catégories

                //Si l'user veut les afficher par ... (alors il y a by dans l'url)
                if(isset($_GET['orderBy'])){
                    //en fonction du parametre on adapte la fonction
                    switch($_GET['orderBy']){
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
                $productAddress = getAddress($_GET['id'], false); //on chope également son adresse

                $title = 'La Boîte de Concert - ' . $product['name'];
                $view = 'views/product_unique.php';
                break;

            case 'add': //dans le cas ou l'user veut ajouter un produit a son panier

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

                //sinon on l'ajoute au panier
                //en sauvegardant les infos nécessaires
                $product = getProduct($_GET['id']);
                $productAddress = getAddress($_GET['id'], false); //on chope également son adresse


                $_SESSION['cart'] .= [
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'addressNumber' => $productAddress['number'],
                    'addressStreet' => $productAddress['street'],
                    'addressTown' => $productAddress['town'],
                    'addressPostalCode' => $productAddress['postal_code'],
                    'addressCountry' => $productAddress['country']
                ];

                //redirection vers la page des produits
                $products = getProducts(); //on récupère tous les produits

                $title = 'La Boîte de Concert - Produits';
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