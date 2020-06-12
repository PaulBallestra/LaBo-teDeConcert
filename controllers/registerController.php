<?php
    //CONTROLLER DU REGISTER
    require_once 'models/User.php';

    $title = "La Boîte de Concert - Inscription";
    $view = 'views/register.php';

    //Si il y a une action en cours
    if(isset($_GET['action'])){

        //En fonction de l'action on adapte le code
        switch ($_GET['action']){

            case 'new': //pour la création d'un compte

                    //vérif des champs obligatoires (nom, prenom, mail et mdp)
                    if(empty($_POST['lastname']) || empty($_POST['firstname']) || empty($_POST['email']) || empty($_POST['password'])){

                        //Si il n'a pas rempli le nom, on recharge la page en lui disant que le nom est obligatoire
                        $_SESSION['message'] = 'Tous les champs sont obligatoires !';

                        //Et on sauvegarde les anciens inputs pour éviter qu'il retape tout dans le rechargement de la page
                        $_SESSION['old_inputs'] = $_POST;

                        header('Location: index.php?page=register'); //redirection vers la création d'un compte en réaffichant ses anciennes valeurs
                        exit;

                    }else{ //Si il a rempli TOUS les champs

                        $informations = $_POST;

                        $isUserAdded = addUser($informations); //appel de la fonction d'ajout d'un user

                        //On vérifie si l'ajout dans la bd s'est bien passé
                        if(!$isUserAdded[0]){ //si ce n'est pas le cas

                            //Affichage d'un message d'erreur si l'insertion s'est mal passée
                            $_SESSION['message'] = 'Erreur lors de la création de votre compte. Veuillez réessayer.';

                            //Et on sauvegarde les anciens inputs pour éviter qu'il retape tout dans le rechargement de la page
                            $_SESSION['old_inputs'] = $_POST;

                            if($isUserAdded[1] == true) //si l'erreur et a cause de l'email déjà existante on modifie le message envoyé a l'user
                                $_SESSION['message'] = 'L\'email que vous désirez est déjà utilisée. Veuillez la changer.';

                            header('Location: index.php?page=register'); //redirection vers la création d'un compte en réaffichant ses anciennes valeurs
                            exit;

                        }else{ //Si ça s'est bien passé alors on enregistre ses données dans la session

                            $_SESSION['is_connected'] = 1; //on passe le flag de connexion à 1

                            //on indique a l'user si son compte a pu étre créé ou non
                            $_SESSION['message'] = $_SESSION['user']['firstname'] . ' votre compte a bien été enregistré, bienvenue !';

                            header('Location: index.php'); //redirection vers l'index
                            exit;
                        }
                    }
                break;

        }
    }