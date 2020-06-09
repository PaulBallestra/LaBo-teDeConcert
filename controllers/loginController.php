<?php

    require_once 'models/User.php';

    $title = "La Boîte de Concert - Connexion";
    $view = 'views/login.php';

    if(isset($_GET['action'])){

        switch($_GET['action']){

            case 'connect': //Si il veut se connecter on vérifie ses identifiants

                //on vérifie qu'il a rempli les champs email et mdp
                if(empty($_POST['email']) || empty($_POST['password'])){ //Si ce n'est pas le cas

                    //Affichage du message comme quoi ce ne sont pas les bons identifiants
                    $_SESSION['message'] = 'Vous devez renseigner tous les champs.';

                    $_SESSION['old_inputs'] = $_POST; //on ne sauvegarde les anciennes valeurs

                    //redirection vers la page de connexion mais avec ses anciennes valeurs (email si y'en a)
                    header('Location: index.php?page=login');
                    exit;

                }else{ //si il a rempli tous les champs alors on vérifie si ce sont les bonnes paires d'identifiant/mdp

                    $informations = $_POST; //on stocke les identifiants

                    $isUserConnected = connectUser($informations); //on stocke le result de la fonction de connection dans la $user

                    //on vérifie si il a réussi a se connecter
                    if($isUserConnected[0] == false){ //Si il n'a pas réussi en raison d'un identifiant incorrect

                        //Affichage du message comme quoi ce ne sont pas les bons identifiants
                        $_SESSION['message'] = 'Identifiants incorrects !';

                        if($isUserConnected[1]) //Si l'erreur 1 est vraie alors c'est que l'email n'existe pas et on override le message
                            $_SESSION['message'] = 'L\'adresse email n\'est pas reconnue. Veuillez créer un compte.';

                        $_SESSION['old_inputs'] = $_POST; //on ne sauvegarde que l'email

                        //redirection vers la page de connexion mais avec ses anciennes valeurs (email)
                        header('Location: index.php?page=login');
                        exit;

                    }else{ //si il a réussi l'identifiant/mdp

                        $_SESSION['is_connected'] = 1; //on passe le flag de connexion à 1

                        $_SESSION['user'] = [
                            'id' => $isUserConnected[0]['id'],
                            'firstname' => $isUserConnected[0]['firstname'],
                            'lastname' => $isUserConnected[0]['lastname'],
                            'email' => $isUserConnected[0]['email'],
                            'is_admin' => $isUserConnected[0]['is_admin'],
                            'phone' => $isUserConnected[0]['phone']
                        ];

                        //on indique a l'user qu'il est bien connecté
                        $_SESSION['message'] = $_SESSION['user']['firstname'] . ' connexion établie ! ';

                        header('Location: index.php'); //redirection vers l'index
                        exit;

                    }

                }
                break;
        }
    }