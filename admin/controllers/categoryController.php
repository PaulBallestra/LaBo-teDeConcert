<?php
    //CONTROLLER DES CATÉGORIES
    require 'models/Category.php';

    //si on a recu un parametre dans action
    if(isset($_GET['action'])){

        //en fonction de cette action
        switch($_GET['action']){

            case 'list': //affichage de toute les catégories

                $categories = getCategories();

                //on modifie la variable du nom de la page et de la view
                $title = "La Boîte de Concert - Gestion Catégories";
                $view = 'views/categories_list.php';
                break;

            case 'new': //dans le cas ou l'action est de créer une nouvelle catégorie

                $title = "La Boîte de Concert - Création Catégorie";
                $view = 'views/create_category.php';
                break;

            case 'add': //si l'admin a décidé de valider les informations, on vérifie que tout va bien et on l'ajoute

                //on vérifie que rien n'est vide
                if(empty($_POST['categoryName']) || empty($_POST['categoryDescription']) || empty($_FILES['categoryImage'])){

                    //Si il a oublié un champ on l'indique
                    $_SESSION['message'] = 'Tous les champs sont obligatoires !';

                    //Et on sauvegarde les anciens inputs pour éviter qu'il retape tout dans le rechargement
                    $_SESSION['old_inputs'] = $_POST;

                    header('Location: index.php?page=categories&action=new'); //lien vers la page de création d'une catégorie
                    exit;

                }else{ //sinon, on lance la requete d'enregistrement d'une nouvelle catégorie

                    $informations = $_POST;

                    $result = addCategory($informations); //appel de la fonction d'ajout d'une catégorie

                    $_SESSION['message'] = $result ? 'Catégorie enregistrée !' : 'Erreur lors de l\'enregistrement...';

                    header('Location: index.php?page=categories&action=list'); //redirection vers la liste des artistes
                    exit;

                }

                break;

            case 'update': //dans le cas ou l'action est de modifier une catégorie

                //on vérifie que l'id n'est pas vide et qu'il y a obligatoirement un id
                if(!isset($_GET['id']) || !ctype_digit($_GET['id'])){

                    //on renvoit vers la page des listes de catégories avec un message d'erreur
                    $categories = getCategories();

                    //on modifie la variable du nom de la page et de la view
                    $title = "La Boîte de Concert - Gestion Catégories";
                    $view = 'views/categories_list.php';

                    $_SESSION['message'] = 'Une erreur est survenue. Veuillez réessayer.';

                }else if(!checkCategoryExists($_GET['id'])){ //On check ensuite que l'id existe bien dans la bd

                    //si ce n'est pas le cas en renvoit vers la page des catégories avec un message

                    //on renvoit vers la page des listes de catégories avec un message d'erreur
                    $categories = getCategories();

                    //on modifie la variable du nom de la page et de la view
                    $title = "La Boîte de Concert - Gestion Catégories";
                    $view = 'views/categories_list.php';

                    $_SESSION['message'] = 'Cette catégorie n\'existe pas.';

                }else {//sinon on continue l'opération en l'affichant dans son formulaire

                    $category = getCategory($_GET['id']); //on récupère la categorie selectionnée

                    $title = "Le Boîte de Concert - Modification " . $category['name'];
                    $view = 'views/update_category.php';
                }
                break;

            default:
                //si il y a un problème dans l'url, on renvoit sur la page des catégories
                $categories = getCategories();

                //on modifie la variable du nom de la page et de la view
                $title = "La Boîte de Concert - Gestion Catégories";
                $view = 'views/categories_list.php';
                break;

        }

    }else{

        //si il y a un problème dans le lien, on le renvoit vers le dashboard
        header('Location: index.php');
        exit;

    }