<?php
    //CONTROLLER DES PRODUITS
    require 'models/Product.php';
    require 'models/Category.php'; //pour afficher toutes les catégories lors de la création et la modification d'un produit

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

            case 'new': //dans le cas ou il veut créer un nouveau produit

                $categories = getCategories(); //on récupère toutes les catégories pour les afficher dans le select

                $title = "La Boîte de Concert - Création Produit";
                $view = 'views/create_product.php';
                break; //lorsque l'action est de créer un nouveau produit

            case 'add': //lorsque l'action et d'envoyer le produit dans la base de donnée

                $informations = $_POST;
                $informations += $_FILES;

                $result = addProduct($informations); //appel de la fonction d'ajout d'une catégorie

                if($result[1] == true){ //vérification qu'il n'y a pas de champs vide (en bd)

                    $_SESSION['message'] = 'Tous les champs sont obligatoires !';

                    //Et on sauvegarde les anciens inputs pour éviter qu'il retape tout dans le rechargement
                    $_SESSION['old_inputs'] = $_POST;
                    $_SESSION['old_inputs'] += $_FILES; //également les images

                    header('Location: index.php?page=products&action=new'); //lien vers la page de création d'une catégorie
                    exit;

                }else{
                    //si tous s'est bien passé on renvoit sur la liste des produits
                    $_SESSION['message'] = 'Produit enregistré !';

                    header('Location: index.php?page=products&action=list'); //lien vers la page de création d'une catégorie
                }
                exit;

                break;

            case 'display': //dans le cas ou il veut afficher un produit spécifique
                break;

            case 'delete':
                //Appel d'une fonction qui supprimera l'artiste
                $resultDeleteProduct = deleteProduct($_GET['id']);

                $_SESSION['message'] = $resultDeleteProduct ? 'Le produit a bien été supprimé !' : 'Erreur lors de la suppresion...';

                header('Location: index.php?page=products&action=list'); //redirection vers la liste des artistes
                exit;
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
