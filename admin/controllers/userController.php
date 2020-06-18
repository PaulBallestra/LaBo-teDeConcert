<?php
    //CONTROLLER DES USERS
    require 'models/User.php';

    //si on a recu un parametre dans action
    if(isset($_GET['action'])){

        //en fonction de cette action
        switch($_GET['action']){

            case 'list': //affichage de toute les users

                $users = getUsers();

                //on modifie la variable du nom de la page et de la view
                $title = "La Boîte de Concert - Gestion Utilisateurs";
                $view = 'views/users_list.php';
                break;

            case 'new': //dans le cas ou l'admin veut créer un nouvel user
                $title = "La Boîte de Concert - Création Utilisateur";
                $view = 'views/create_user.php';
                break;

            case 'add': //dans le cas ou l'admin a cliqué sur valider un user
                $informations = $_POST;

                if(!ctype_digit($informations['userPhone'])){
                    $_SESSION['message'] = 'Vérifiez le type des champs !';

                    //Et on sauvegarde les anciens inputs pour éviter qu'il retape tout dans le rechargement
                    $_SESSION['old_inputs'] = $_POST;

                    header('Location: index.php?page=users&action=new'); //lien vers la page de création d'un user
                    exit;
                }

                $result = addUser($informations); //appel de la fonction d'ajout d'une catégorie

                if($result[1] == true){ //vérification qu'il n'y a pas déjà la meme adresse email

                    $_SESSION['message'] = 'Email déjà utilisée. Veuillez recommencer.';

                    //Et on sauvegarde les anciens inputs pour éviter qu'il retape tout dans le rechargement
                    $_SESSION['old_inputs'] = $_POST;

                    header('Location: index.php?page=users&action=new'); //lien vers la page de création d'un user
                    exit;

                }else if($result[2] == true){ //vérification des champs non vide

                    $_SESSION['message'] = 'Tous les champs sont obligatoires !';

                    //Et on sauvegarde les anciens inputs pour éviter qu'il retape tout dans le rechargement
                    $_SESSION['old_inputs'] = $_POST;

                    header('Location: index.php?page=users&action=new'); //lien vers la page de création d'un user
                    exit;

                }else{
                    //si tous s'est bien passé on renvoit sur la liste des produits
                    $_SESSION['message'] = 'Utilisateur enregistré !';

                    header('Location: index.php?page=users&action=list'); //lien vers la page de création d'une catégorie
                }
                exit;
                break;

            case 'update': //dans le cas ou l'admin veut mettre a jour un user

                //on vérifie que l'id n'est pas vide et qu'il y a obligatoirement un id
                if(!isset($_GET['id'])){

                    //on renvoit vers la page des listes des users avec un message d'erreur
                    $users = getUsers();

                    //on modifie la variable du nom de la page et de la view
                    $title = "La Boîte de Concert - Gestion Utilisateurs";
                    $view = 'views/users_list.php';

                    $_SESSION['message'] = 'Une erreur est survenue. Veuillez réessayer.';

                }else {//sinon on continue l'opération en l'affichant dans son formulaire

                    $user = getUser($_GET['id']); //on récupère l'user

                    $title = "Le Boîte de Concert - Modification User " . $user['id'];
                    $view = 'views/update_user.php';
                }

                break;

            case 'updated': //dans le cas ou il a cliqué sur valider apres l'update d'un user

                $informations = $_POST; //on stocke les données en post dans $informations

                $user = updateUser($_GET['id'], $informations); //appel de la fonction d'update

                //on vérifie qu'il n'y a pas une erreur de champs non rempli
                if($user[1]){

                    $user = getUser($_GET['id']); //on récupère l'user selectionné

                    $_SESSION['old_inputs'] = $informations; //on stocke les anciennes infos
                    $_SESSION['message'] = 'Tous les champs sont obligatoires !';

                    $title = "Le Boîte de Concert - Modification User " . $user['id'];
                    $view = 'views/update_user.php';

                }else if($user[2]){

                    $user = getUser($_GET['id']); //on récupère l'user selectionné

                    $_SESSION['old_inputs'] = $informations; //on stocke les anciennes infos
                    $_SESSION['message'] = 'Vérifiez le type des champs !';

                    $title = "Le Boîte de Concert - Modification User " . $user['id'];
                    $view = 'views/update_user.php';

                }else {

                    //on renvoit vers la page des listes des users avec un message
                    $users = getUsers();

                    $_SESSION['message'] = 'Utilisateur modifié avec succès !';

                    //on modifie la variable du nom de la page et de la view
                    $title = "La Boîte de Concert - Gestion Utilisateurs";
                    $view = 'views/users_list.php';
                }

                break;

            case 'delete': //dans le cas ou il veut supprimer un user

                //Appel d'une fonction qui supprimera l'user
                $resultDeleteUser = deleteUser($_GET['id']);

                $_SESSION['message'] = $resultDeleteUser ? 'L\'utilisateur a bien été supprimé !' : 'Erreur lors de la suppresion...';

                header('Location: index.php?page=users&action=list'); //redirection vers la liste des users
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
