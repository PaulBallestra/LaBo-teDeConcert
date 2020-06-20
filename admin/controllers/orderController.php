<?php
    //CONTROLLER DES COMMANDES
    require 'models/Product.php';
    require 'models/Category.php'; //pour afficher toutes les catégories lors de la création et la modification d'un produit
    require 'models/Address.php'; //pour afficher les adresses
    require 'models/Order.php'; //pour les commandes

    //si on a recu un parametre dans action
    if(isset($_GET['action'])){

        //en fonction de cette action
        switch($_GET['action']){

            case 'list': //affichage de toute les produits

                $orders = getOrders();

                //on modifie la variable du nom de la page et de la view
                $title = "La Boîte de Concert - Gestion Commandes";
                $view = 'views/orders_list.php';
                break;

            case 'display': //dans le cas ou il veut afficher en détail la commande

                if(!isset($_GET['id'])){
                    //on renvoit vers la page des listes des commandes avec un message d'erreur
                    $orders = getOrders();

                    //on modifie la variable du nom de la page et de la view
                    $title = "La Boîte de Concert - Gestion Commandes";
                    $view = 'views/orders_list.php';

                    $_SESSION['message'] = 'Une erreur est survenue. Veuillez réessayer.';
                }

                if(!ctype_digit($_GET['id'])){
                    //on renvoit vers la page des listes des orders avec un message d'erreur
                    $orders = getOrders();

                    //on modifie la variable du nom de la page et de la view
                    $title = "La Boîte de Concert - Gestion Commandes";
                    $view = 'views/orders_list.php';

                    $_SESSION['message'] = 'Id inconnu.';
                }


                $order = getOrder($_GET['id']); //on récupère la commande a afficher
                $client = explode("/", $order['user']);

                $title = "La Boîte de Concert - Commande N°" . $order['id_order'];
                $view = 'views/order_details.php';

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
