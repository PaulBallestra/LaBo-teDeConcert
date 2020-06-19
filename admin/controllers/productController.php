<?php
    //CONTROLLER DES PRODUITS
    require 'models/Product.php';
    require 'models/Category.php'; //pour afficher toutes les catégories lors de la création et la modification d'un produit
    require 'models/Address.php'; //pour afficher les adresses

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

                }else if($result[2] == true){ //vérification si il n'y a pas d'erreur comme des lettres dans les champs number

                    $_SESSION['message'] = 'Vérifiez le type des champs !';

                    //Et on sauvegarde les anciens inputs pour éviter qu'il retape tout dans le rechargement
                    $_SESSION['old_inputs'] = $_POST;
                    $_SESSION['old_inputs'] += $_FILES; //également les images

                    header('Location: index.php?page=products&action=new'); //lien vers la page de création d'un produit
                    exit;

                }else if($result[3] == true){ //si il y a l'erreur du type des images

                    $_SESSION['message'] = 'Vérifiez le type des images !';

                    //Et on sauvegarde les anciens inputs pour éviter qu'il retape tout dans le rechargement
                    $_SESSION['old_inputs'] = $_POST;
                    $_SESSION['old_inputs'] += $_FILES; //également les images

                    header('Location: index.php?page=products&action=new'); //lien vers la page de création d'un produit
                    exit;

                }else{

                    //si tous s'est bien passé on renvoit sur la liste des produits
                    $_SESSION['message'] = 'Produit enregistré !';

                    header('Location: index.php?page=products&action=list'); //lien vers la liste des produits
                    exit;
                }

                break;

            case 'update': //dans le cas ou il veut modifier un produit spécifique

                //on vérifie que l'id n'est pas vide et qu'il y a obligatoirement un id
                if(!isset($_GET['id'])){

                    //on renvoit vers la page des listes de catégories avec un message d'erreur
                    $products = getProducts();

                    //on modifie la variable du nom de la page et de la view
                    $title = "La Boîte de Concert - Gestion Produits";
                    $view = 'views/products_list.php';

                    $_SESSION['message'] = 'Une erreur est survenue. Veuillez réessayer.';

                }else if(!getProduct($_GET['id'])){ //On check ensuite que l'id existe bien dans la bd (donc si ça nous renvoit un produit et pas false)

                    //si ce n'est pas le cas en renvoit vers la page des produits avec un message

                    //on renvoit vers la page des listes de catégories avec un message d'erreur
                    $products = getProducts();

                    //on modifie la variable du nom de la page et de la view
                    $title = "La Boîte de Concert - Gestion Produits";
                    $view = 'views/products_list.php';

                    $_SESSION['message'] = 'Ce produit n\'existe pas.';

                }else {//sinon on continue l'opération en l'affichant dans son formulaire

                    $categories = getCategories(); //on récupère les categories pour les afficher dans le select
                    $product = getProduct($_GET['id']); //on récupère le produit selectionné
                    $productAddress = getAddress($_GET['id'], false); //on récupère l'adresse du produit

                    $title = "Le Boîte de Concert - Modification " . $product['name'];
                    $view = 'views/update_product.php';
                }
                break;

            case 'delete':
                //Appel d'une fonction qui supprimera le produit
                $resultDeleteProduct = deleteProduct($_GET['id']);

                $_SESSION['message'] = $resultDeleteProduct ? 'Le produit a bien été supprimé !' : 'Erreur lors de la suppresion...';

                header('Location: index.php?page=products&action=list'); //redirection vers la liste des users
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
