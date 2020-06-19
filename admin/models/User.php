<?php
    //MODEL DES USERS

    //FONCTION QUI VA AJOUTER UN NOUVEL USER
    function addUser($informations)
    {
        $db = dbConnect();

        //en fonction de la valeur de la checkbox, on adapte le booléen
        if(isset($informations['userIsAdmin']))
            $isUserAdmin = true;
        else
            $isUserAdmin = false;

        //vérification des champs non vides
        if(empty($informations['userLastname']) || empty($informations['userFirstname']) || empty($informations['userEmail']) || empty($informations['userPassword']) || empty($informations['userPhone']))
            return [false, false, true];

        //vérification que l'email n'est pas déjà utilisée
        if(!checkEmailAlreadyUsed($informations['userEmail'])){
            $queryAddUser = $db->prepare('INSERT INTO users (lastname, firstname, email, password, phone, is_admin) VALUES (?, ?, ?, ?, ?, ?)');
            $resultAddUser = $queryAddUser->execute([
                $informations['userLastname'],
                $informations['userFirstname'],
                $informations['userEmail'],
                hash('md5', $informations['userPassword']),
                $informations['userPhone'],
                $isUserAdmin
            ]);

            return [$resultAddUser, false, false];
        }else{
            return [false, true, false];
        }



    }

    //FONCTION QUI VA METTRE A JOUR UN USER EN FONCTION DE SON ID ET DE SES INFORMATIONS
    function updateUser($id, $informations)
    {
        $db = dbConnect();

        //vérification des champs non vide
        if(empty($informations['userFirstname']) || empty($informations['userLastname']) || empty($informations['userEmail']) || empty($informations['userPhone']))
            return [false, true, false];

        //vérification du type du numéro de téléphone
        if(!ctype_digit($informations['userPhone']))
            return [false, false, true];

        $query = 'UPDATE users SET firstname = ?, lastname = ?, email = ?, phone = ?'; //string qui contiendra la query finale d'update

        $queryExecuteContent = $informations['userFirstname'] . ',';
        $queryExecuteContent .= $informations['userLastname'] . ',';
        $queryExecuteContent .= $informations['userEmail'] . ',';
        $queryExecuteContent .= $informations['userPhone']. ',';

        //vérification si le passord a été modifié
        if(isset($informations['userPassword']) && !empty($informations['userPassword'])) {
            $query .= ', password = ?';
            $queryExecuteContent .= hash('md5', $informations['userPassword']) . ',';
        }

        //Vérification de la ckeckbox isAdmin
        if(isset($informations['userIsAdmin'])){
            $query .= ', is_admin = ?';

            if($informations['userIsAdmin'] == 'on')
                $queryExecuteContent .= '1,';
            else
                $queryExecuteContent .= '0,';
        }


        $query .= ' WHERE id = ?';
        $queryExecuteContent .= $id; //on ferme la queryString avec l'id de l'user


        $queryUpdateUser = $db->prepare($query);
        $queryUpdateUser->execute(explode(",", $queryExecuteContent));

        return [$queryUpdateUser, false, false];
    }

    //FONCTION QUI RENVOIT VRAI SI L'EMAIL EST DEJA UTILISEE
    function checkEmailAlreadyUsed($email){

        $db = dbConnect();

        //Requete qui va recherche si l'email utilisée n'est pas déjà prise
        $queryTestEmail = $db->prepare("SELECT email, id FROM users WHERE email = ?");
        $queryTestEmail->execute([
            $email
        ]);

        //On stocke l'unique ligne qui revient dans la variable emailAlreadyExist
        $emailAlreadyExist = $queryTestEmail->fetch();

        return $emailAlreadyExist;
    }

    //FONCTION QUI SUPPRIME UN UTILISATEUR EN FONCTION DE SON ID
    function deleteUser($id)
    {
        $db = dbConnect();

        //on supprime également l'adresse qui lui est lié
        $queryDeleteAddressUser = $db->prepare('
            DELETE 
            FROM addresses
            WHERE id_user = ?');

        $queryDeleteAddressUser->execute([$id]);

        //on supprime le panier qui lui est lié
        $queryDeleteCartUser = $db->prepare('
            DELETE
            FROM carts
            WHERE id_user = ?
        ');
        $queryDeleteCartUser->execute([$id]);

        //suppresion de l'user en question
        $queryDeleteUser = $db->prepare('DELETE FROM users WHERE id = ?');
        $queryDeleteUser->execute([
            $id
        ]);

        return $queryDeleteUser;
    }

    //FONCTION QUI VA CHOPER LE NOMBRE TOTAL D'USERS
    function getNumberOfUsers()
    {
        $db = dbConnect();

        $queryNumberOfUsers = $db->query("SELECT COUNT(id) as numberOfUsers FROM users");
        $numberOfUsers = $queryNumberOfUsers->fetch();
        $queryNumberOfUsers->closeCursor();

        return $numberOfUsers['numberOfUsers'];
    }

    //FONCTION QUI VA RETOURNER TOUS LES USERS
    function getUsers()
    {
        $db = dbConnect();

        $queryGetUsers = $db->query('SELECT * FROM users');
        $resultUsers = $queryGetUsers->fetchAll();

        return $resultUsers;
    }

    //FONCTION QUI VA RETOURNER UN USER EN FONCTION DE SON ID
    function getUser($id)
    {
        $db = dbConnect();

        $queryGetUser = $db->prepare('SELECT * FROM users WHERE id = ?');

        $queryGetUser->execute([
            $id
        ]);

        return $queryGetUser->fetch();
    }
