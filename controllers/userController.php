<?php
    //CONTROLER DE L'USER
    require 'models/User.php';
    require 'models/Address.php'; //on require le model des adresses

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
                                $_SESSION['message'] = 'Informations modifiées avec succès !';

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

                            }elseif($userProfileUpdated[0] == false){ //Si il y a eu un probleme

                                if($userProfileUpdated[1] == true && $userProfileUpdated[2] == false){
                                    //Affichage du message si il y a eu un problème avec l'email
                                    $_SESSION['message'] = 'L\'email que vous désirez est déjà utilisée. Veuillez la changer.';
                                }elseif($userProfileUpdated[1] == false && $userProfileUpdated[2] == true){
                                    //Affichage du message si il y a eu un problème avec le téléphone
                                    $_SESSION['message'] = 'Ce numéro de téléphone n\'existe pas. Veuillez le changer.';
                                }else{
                                    //Affichage du message si il y a eu un problème si il y a eu un problème en bd
                                    $_SESSION['message'] = 'Erreur lors de la modification de vos informations. Veuillez recommencer.';
                                }

                                //Et on sauvegarde les anciens inputs pour éviter qu'il retape tout dans le rechargement de la page
                                $_SESSION['old_inputs'] = $_POST;

                                header('Location: index.php?page=profile&action=update&id=' . $_SESSION['user']['id']); //redirection vers l'update du profil en réaffichant ses anciennes valeurs
                                exit;
                            }

                            break;

                        case 'update_address': //dans le cas ou il a voulu modifier son adresse


                            if(!checkAddressAlreadySet($_SESSION['user']['id'])){
                                $userAddressUpdated = addUserAddress($_POST, $_SESSION['user']['id']);
                            }else{
                                $userAddressUpdated = updateUserAddress($_POST, $_SESSION['user']['id']);
                            }



                            //si il y a eu une erreur avec les champs vides
                            if($userAddressUpdated[1]){

                                //Et on sauvegarde les anciens inputs
                                $_SESSION['old_inputs'] = $_POST;

                                //on lui affichera le message comme quoi tous les champs sont obligatoires
                                $_SESSION['message'] = 'Tous les champs sont obligatoires !';

                                //et on redirige vers la meme page mais avec ses anciennes valeurs
                                header('Location: index.php?page=profile&action=update&id=' . $_SESSION['user']['id']); //redirection vers l'update du profil (adresse) en réaffichant ses anciennes valeurs
                                exit;

                            }else{ //Si il n'y a pas eu d'erreur de champs vides

                                //on vérifie qu'il n'y en a pas eu non plus avec la requete
                                if(!$userAddressUpdated[0]){

                                    //Et on sauvegarde les anciens inputs
                                    $_SESSION['old_inputs'] = $_POST;

                                    if($userAddressUpdated[2]) //si il y a une erreur de type nombre sur le numéro ou le code _postal
                                        $_SESSION['message'] = 'Veuillez renseigner des valeurs corrects pour le numéro et le code postal';
                                    else
                                        $_SESSION['message'] = 'Une erreur est survenue. Veuillez recommencer.'; //on lui affichera le message comme quoi il y a eu un problème

                                    //et on redirige vers la meme page mais avec ses anciennes valeurs
                                    header('Location: index.php?page=profile&action=update&id=' . $_SESSION['user']['id']); //redirection vers l'update du profil (adresse) en réaffichant ses anciennes valeurs
                                    exit;

                                }else{ //Si tout s'est bien passé, alors on enregistre également en session l'adresse de l'user

                                    $userAddress = getAddress($_SESSION['user']['id'], true); //on enregistre son address dans une variables pour l'enregistrer ensuite en session

                                    $_SESSION['user']['address'] = [
                                        'id' => $userAddress['id'],
                                        'number' => $userAddress['number'],
                                        'street' => $userAddress['street'],
                                        'town' => $userAddress['town'],
                                        'postal_code' => $userAddress['postal_code'],
                                        'country' => $userAddress['country']
                                    ];

                                    //Affichage d'un message quand tout s'est bien passé
                                    $_SESSION['message'] = 'Votre adresse a bien été ajoutée !'; //on lui affichera le message comme quoi il y a eu un problème

                                    //on redirige vers la meme page mais avec les infos modifiées
                                    header('Location: index.php?page=profile&action=update&id=' . $_SESSION['user']['id']);
                                    exit;
                                }

                            }

                            break;
                    }

                }

                break;

        }
    }else{
        require 'controllers/indexController.php'; //Redirection vers l'index si l'user n'est pas connecté et qu'il veut atteindre les page des profils
    }