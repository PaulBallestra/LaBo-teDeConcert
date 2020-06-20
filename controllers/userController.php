<?php
    //CONTROLER DE L'USER
    require 'models/User.php';
    require 'models/Address.php'; //on require le model des adresses
    require 'models/Cart.php';
    require 'models/Product.php';
    require 'models/Order.php';

    //On vérifie qu'il y a bien un post envoyé
    if(isset($_GET['page']) && isset($_SESSION['is_connected'])) {

        switch ($_GET['page']) {

            case 'profile': //dans le cas ou il veut afficher sa page de profil

                if(isset($_GET['action'])){

                    switch ($_GET['action']){ //en fonction de l'action, on adapte la sortie

                        case 'update': //dans le cas ou l'user veut modifier des informations de son compte

                            if(isset($_GET['id'])){ //si il y a bien un id envoyé

                                $title = "La Boîte de Concert - Modification Profil";
                                $view = 'views/update_profil.php';

                            }else{ //redirection vers sa page de profil
                                $title = "La Boîte de Concert - Votre Profil";
                                $view = 'views/profil.php';
                            }
                            break;

                        case 'delete': //dans le cas ou l'user veut supprimer son compte
                            $title = "La Boîte de Concert - Suppression Profil";
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

                                $title = "La Boîte de Concert - Modification Profil";
                                $view = 'views/update_profil.php';

                            }elseif($userProfileUpdated[0] == false){ //Si il y a eu un probleme

                                if($userProfileUpdated[1] == true && $userProfileUpdated[2] == false){
                                    //Affichage du message si il y a eu un problème avec l'email
                                    $_SESSION['message'] = 'L\'email que vous désirez est déjà utilisée. Veuillez la changer.';
                                }elseif($userProfileUpdated[1] == false && $userProfileUpdated[2] == true){
                                    //Affichage du message si il y a eu un problème avec le téléphone
                                    $_SESSION['message'] = 'Ce numéro de téléphone n\'existe pas. Veuillez le changer.';
                                }elseif($userProfileUpdated[3] == true){
                                    //Affichage du message si il y a eu un problème avec le téléphone
                                    $_SESSION['message'] = 'Votre profil ne peut être changé si vous ne rentrez rien.';
                                }else{
                                    //Affichage du message si il y a eu un problème si il y a eu un problème en bd
                                    $_SESSION['message'] = 'Erreur lors de la modification de vos informations. Veuillez recommencer.';
                                }

                                //Et on sauvegarde les anciens inputs pour éviter qu'il retape tout dans le rechargement de la page
                                $_SESSION['old_inputs'] = $_POST;

                                $title = "La Boîte de Concert - Modification Profil";
                                $view = 'views/update_profil.php';
                            }

                            break;

                        case 'update_address': //dans le cas ou il a voulu modifier son adresse

                            if(!checkAddressExists($_SESSION['user']['id']))
                                $userAddressUpdated = addUserAddress($_POST, $_SESSION['user']['id']);
                            else
                                $userAddressUpdated = updateUserAddress($_POST, $_SESSION['user']['id']);


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

                        case 'delete_product': //dans le cas ou l'user veut supprimer un item de son panier

                            //On vérifie que son panier n'est pas vide avant de le supprimer
                            if(empty(getProductsInCart(getIdCartOfUser($_SESSION['user']['id'])))){
                                $_SESSION['message'] = 'Vous n\'avez aucun produits. ';
                                $numberProductsInCart = sizeof(getProductsInCart(getIdCartOfUser($_SESSION['user']['id'])));
                                header('Location: index.php?page=profile');
                                exit;
                            }

                            //si l'id n'est pas set, on renvoit sur le profil
                            if(!isset($_GET['id'])){
                                $_SESSION['message'] = 'Une erreur est survenue.';
                                $numberProductsInCart = sizeof(getProductsInCart(getIdCartOfUser($_SESSION['user']['id'])));
                                header('Location: index.php?page=profile');
                                exit;
                            }

                            //si l'id n'est pas de type number, on renvoit sur le profil
                            if(!ctype_digit($_GET['id'])){
                                $_SESSION['message'] = 'L\'id n\'est pas valide.';
                                $numberProductsInCart = sizeof(getProductsInCart(getIdCartOfUser($_SESSION['user']['id'])));
                                header('Location: index.php?page=profile');
                                exit;
                            }

                            //si il ne possède pas cet id dans son panier, on renvoit sur la page de profil (également pour regler le probleme de si il supprime puis va sur payer puis revient, lorsqu'il revient, cela supprimait une 2eme fois)
                            if(empty(checkProductInCart($_GET['id'],getIdCartOfUser($_SESSION['user']['id'])))){
                                $numberProductsInCart = sizeof(getProductsInCart(getIdCartOfUser($_SESSION['user']['id'])));
                                header('Location: index.php?page=profile');
                                exit;
                            }

                            //si tout se passe bien, on supprime le produit
                            unset($_SESSION['user']['cart'][array_search($_GET['id'], $_SESSION['user']['cart'])]);

                            $_SESSION['user']['cart'] = array_merge($_SESSION['user']['cart']); //on merge pour reset les index du cart en session

                            deleteProductInCart(getIdCartOfUser($_SESSION['user']['id']), $_GET['id']);

                            $_SESSION['message'] = 'Votre produit a bien été supprimé de son panier !';

                            $numberProductsInCart = sizeof(getProductsInCart(getIdCartOfUser($_SESSION['user']['id'])));

                            $title = "La Boîte de Concert - Votre Profil";
                            $view = 'views/profil.php';
                            break;

                        case 'pay_cart': //dans le cas ou l'user veut aller sur la page de paiement de sa commande

                            $numberProductsInCart = sizeof(getProductsInCart(getIdCartOfUser($_SESSION['user']['id'])));

                            $title = "La Boîte de Concert - Paiement de votre commande";
                            $view = 'views/order_cart.php';
                            break;

                        case 'paid': //dans le cas ou l'user a cliqué sur Valider de la page de paiement

                            if(isset($_GET['id'])){ //on vérifie bien qu'on ait un id de cart

                                //check du type de l'id envoyé
                                if(!ctype_digit($_GET['id'])){
                                    $_SESSION['message'] = 'L\'id ne correspond pas.';

                                    $numberProductsInCart = sizeof(getProductsInCart(getIdCartOfUser($_SESSION['user']['id'])));

                                    $title = "La Boîte de Concert - Votre Profil";
                                    $view = 'views/profil.php';
                                }else if($_SESSION['user']['id'] != $_GET['id']){ //check si c'est bien l'actuel user et non un autre
                                    $_SESSION['message'] = 'Une erreur est survenue. Veuillez recommencer.';

                                    $numberProductsInCart = sizeof(getProductsInCart(getIdCartOfUser($_SESSION['user']['id'])));
                                    $title = "La Boîte de Concert - Votre Profil";
                                    $view = 'views/profil.php';
                                }else { //sinon

                                    //on enregistre la commande
                                    $nbProducts = sizeof(getProductsInCart(getIdCartOfUser($_SESSION['user']['id']))); //nombre de produits dans le panier

                                    $order = addOrder($_GET['id'], $_SESSION['user']['cart']['price']); //on ajoute la commande (et ça nous retourne l'id de la commande créée)

                                    for ($i = 0; $i < $nbProducts; $i++) {

                                        $informationsProduct = [
                                            'id' => $_SESSION['user']['cart'][$i]['id'],
                                            'name' => $_SESSION['user']['cart'][$i]['name'],
                                            'capacity' => getProduct($_SESSION['user']['cart'][$i]['id'])['capacity'],
                                            'price' => getProduct($_SESSION['user']['cart'][$i]['id'])['price'],
                                            'addressNumber' => $_SESSION['user']['cart'][$i]['addressNumber'],
                                            'addressStreet' => $_SESSION['user']['cart'][$i]['addressStreet'],
                                            'addressTown' => $_SESSION['user']['cart'][$i]['addressTown'],
                                            'addressPostalCode' => getAddress($_SESSION['user']['cart'][$i]['id'], false)['postal_code'],
                                            'addressCountry' => getAddress($_SESSION['user']['cart'][$i]['id'], false)['country'],
                                            'quantity' => $_SESSION['user']['cart'][$i]['quantity'],
                                        ];

                                        $informationsUser = [
                                            'id' => $_SESSION['user']['id'],
                                            'lastname' => $_SESSION['user']['lastname'],
                                            'firstname' => $_SESSION['user']['firstname'],
                                        ];

                                        setOrderDetails($order, $informationsProduct, $informationsUser); //on rajoute les details du du produit et de l'user dans la facture
                                        orderedProduct($informationsProduct['id'], $informationsProduct['quantity']);

                                    }

                                    //on supprime son panier actuel (en session)
                                    $_SESSION['user']['cart'] = [];

                                    //on supprime son panier en db
                                    deleteProductsInCart(getIdCartOfUser($_SESSION['user']['id']));

                                    //Et on l'informe que sa commande a bien été passée
                                    $_SESSION['message'] = 'Votre commande est un succès !';

                                    $numberProductsInCart = sizeof(getProductsInCart(getIdCartOfUser($_SESSION['user']['id'])));

                                    $title = "La Boîte de Concert - Votre Profil";
                                    $view = 'views/profil.php';
                                }

                            }else{ //sinon on le renvoit sur le profil

                                $_SESSION['message'] = 'Une erreur est survenue. Veuillez recommencer.';

                                $numberProductsInCart = sizeof(getProductsInCart(getIdCartOfUser($_SESSION['user']['id'])));

                                $title = "La Boîte de Concert - Votre Profil";
                                $view = 'views/profil.php';

                            }

                            break;

                        case 'orders': //dans le cas ou il veut voir ses anciennes commandes


                            //On chope les commandes que l'user possède
                            $orders = getOrders($_SESSION['user']['id']);

                            $title = 'La Boîte de Concert - Vos commandes';
                            $view = 'views/orders_list.php';

                            break;

                        case 'delete_cart': //si il veut supprimer son panier

                            //On vérifie qu'il a des produits dedans avant de le supprimer
                            if(empty(getProductsInCart(getIdCartOfUser($_SESSION['user']['id'])))){
                                $_SESSION['message'] = 'Votre panier est vide.';
                                header('Location: index.php?page=profile');
                                exit;
                            }

                            //on le supprime en session
                            $_SESSION['user']['cart'] = [];

                            //et on supprime les liens en bd
                            deleteProductsInCart(getIdCartOfUser($_SESSION['user']['id']));

                            $numberProductsInCart = 0;

                            $_SESSION['message'] = 'Votre panier a bien été supprimé !';

                            $title = "La Boîte de Concert - Votre Profil";
                            $view = 'views/profil.php';

                            break;

                        case 'delete_profile': //dans le cas ou l'user veut supprimer son compte

                            if(!isset($_GET['id'])){

                                $numberProductsInCart = sizeof(getProductsInCart(getIdCartOfUser($_SESSION['user']['id'])));

                                $_SESSION['message'] = 'Une erreur est survenue !';

                                $title = "La Boîte de Concert - Votre Profil";
                                $view = 'views/profil.php';
                            }

                            if(!ctype_digit($_GET['id'])){
                                $numberProductsInCart = sizeof(getProductsInCart(getIdCartOfUser($_SESSION['user']['id'])));

                                $_SESSION['message'] = 'Cet id n\'existe pas.';

                                $title = "La Boîte de Concert - Votre Profil";
                                $view = 'views/profil.php';
                            }

                            if($_GET['id'] != $_SESSION['user']['id']){
                                $numberProductsInCart = sizeof(getProductsInCart(getIdCartOfUser($_SESSION['user']['id'])));

                                $_SESSION['message'] = 'Cet id n\'est le vôtre !';

                                $title = "La Boîte de Concert - Votre Profil";
                                $view = 'views/profil.php';
                            }

                            $_SESSION['is_connected'] = 0; //on passe le flag de connexion a 0

                            //on vire la session et on supprime l'user
                            unset($_SESSION['user']);

                            deleteUser($_GET['id']);

                            $_SESSION['message'] = 'Votre compte a bien été supprimé ! Au revoir...';

                            header('Location: index.php');
                            exit;

                            break;
                    }

                }else{
                    $numberProductsInCart = sizeof(getProductsInCart(getIdCartOfUser($_SESSION['user']['id'])));

                    $title = "La Boîte de Concert - Votre Profil";
                    $view = 'views/profil.php';
                }

                break;

        }
    }else{
        require 'controllers/indexController.php'; //Redirection vers l'index si l'user n'est pas connecté et qu'il veut atteindre les page des profils
    }