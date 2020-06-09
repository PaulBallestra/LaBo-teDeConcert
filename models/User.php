<?php
    //Model des USERS

    //Fonction qui va ajouter un user
    function addUser($informations)
    {
        $db = dbConnect(); //Connexion

        //Requete qui va recherche si l'email utilisée n'est pas déjà prise
        $queryTestEmail = $db->prepare("SELECT email FROM users WHERE email = ?");
        $queryTestEmail->execute([
            $informations['email']
        ]);

        //On stocke l'unique ligne qui revient dans la variable emailAlreadyExist
        $emailAlreadyExist = $queryTestEmail->fetch();

        //Si elle est false cela veut dire que l'email n'est pas utilisée
        if($emailAlreadyExist == false){

            //Ajout des valeurs de l'user
            $query = $db->prepare("INSERT INTO users (lastname, firstname, email, password) VALUES (?, ?, ?, ?)");
            $result = $query->execute([
                $informations['lastname'],
                $informations['firstname'],
                $informations['email'],
                hash('md5', $informations['password']) //on hash le mot de passe pour le proteger
            ]);

            return [$result, false]; //on retourne le resultat de la query (si ça s'est bien passé ou non) ainsi que false pour indiquer qu'il n'y a pas eu d'erreur d'email déjà utilisée
        }else{
            return [false, true]; //on retourne faux pour indiquer qu'il y a une erreur et true car l'adresse mail existe déjà
        }
    }

    //Fonction qui vérifie les identifiants d'un user pour se connecter
    function connectUser($informations)
    {
        $db = dbConnect(); //Connexion

        //Requete qui va recherche si l'email existe avant de tester la connexion
        $queryTestEmail = $db->prepare("SELECT email FROM users WHERE email = ?");
        $queryTestEmail->execute([
            $informations['email']
        ]);

        $emailExist = $queryTestEmail->fetch(); //si vrai c'est que l'email existe faux sinon

        if($emailExist == true){ //si l'email existe bien on teste la connexion

            $queryTestConnection = $db->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
            $queryTestConnection->execute([
                $informations['email'],
                hash('md5', $informations['password']) //on vérifie les champs email et hash(password)
            ]);

            $user = $queryTestConnection->fetch(); //on récupère l'unique user

            return [$user, false]; //en retourne l'user ET false pour indiquer que l'email existe bien et qu'il y a un compte
        }else{
            return [false, true];
        }
    }