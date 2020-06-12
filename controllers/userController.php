<?php
    //CONTROLER DE L'USER
    require 'models/User.php';


    //On vérifie qu'il y a bien un post envoyé
    if(isset($_GET['page']) && isset($_SESSION['is_connected'])) {

        switch ($_GET['page']) {

            case 'profile': //dans le cas ou il veut afficher sa page de profil
                $title = "La Boîte de Concert - Votre Profil";
                $view = 'views/profil.php';

                if(isset($_GET['action'])){

                    switch ($_GET['action']){

                        case 'update': //dans le cas ou l'user veut modifier des informations de son compte

                            if(isset($_GET['id'])){
                                $title = "La Boîte de Concert - Modification Profil";
                                $view = 'views/update_profil.php';
                            }else{ //redirection vers sa page de profil
                                $title = "La Boîte de Concert - Votre Profil";
                                $view = 'views/profil.php';
                            }
                            break;

                        case 'delete': //dans le cas ou l'user veut supprimer son compte
                            $title = "La Boîte de Concert - Suppresion Profil";
                            $view = 'views/delete_profil.php';
                            break;


                        case 'update_profile': //dans le cas ou il a voulu modifier son profil

                            //on lance la fonction qui va updater ses informations
                            $userProfileUpdated = updateUserProfile($_POST, $_SESSION['user']['id']);

                            //en fonction du resultat renvoyé par la fonction, on adapte le message
                            if($userProfileUpdated[0]){
                                //Affichage du message si tous s'est bien passé
                                $_SESSION['message'] = 'Vous avez modifié vos informations.';

                                //si ca s'est bien passé on modifie les valeurs en session pour qu'elles soient directement actives (mais que si ça s'est bien passé)
                                $user = getUser($_SESSION['user']['id']);
                                $_SESSION['user'] = [
                                    'id' => $user['id'],
                                    'firstname' => $user['firstname'],
                                    'lastname' => $user['lastname'],
                                    'email' => $user['email'],
                                    'is_admin' => $user['is_admin'],
                                    'phone' => $user['phone']
                                ];

                            }elseif($userProfileUpdated[1] == true && $userProfileUpdated[0] == false){ //si l'email est déjà utilisée
                                //Affichage du message si il y a eu un problème
                                $_SESSION['message'] = 'L\'email que vous désirez est déjà utilisée. Veuillez la changer.';

                                //Et on sauvegarde les anciens inputs pour éviter qu'il retape tout dans le rechargement de la page
                                $_SESSION['old_inputs'] = $_POST;

                                header('Location: index.php?page=profile&action=update&id=' . $_SESSION['user']['id']); //redirection vers la création d'un compte en réaffichant ses anciennes valeurs
                                exit;

                            }elseif($userProfileUpdated[0] == false && $userProfileUpdated[1] == false){ //si il y a eu un problème dans la query ou la base de donnée
                                //Affichage du message si il y a eu un problème
                                $_SESSION['message'] = 'Erreur lors de la modification de vos informations. Veuillez recommencer.';

                                //Et on sauvegarde les anciens inputs pour éviter qu'il retape tout dans le rechargement de la page
                                $_SESSION['old_inputs'] = $_POST;

                            }

                            break;

                        case 'update_address': //dans le cas ou il a voulu modifier son adresse
                            break;
                    }

                }

                break;

        }
    }else{
        require 'controllers/indexController.php'; //Redirection vers l'index si l'user n'est pas connecté et qu'il veut atteindre les page des profils
    }