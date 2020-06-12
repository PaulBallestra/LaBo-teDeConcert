<?php
    //Model des USERS

    //FONCTION GET UN UTILISATEUR
    function getUser($id)
    {
        $db = dbConnect();

        $queryGetUser = $db->prepare('SELECT * FROM users WHERE id = ?');

        $queryGetUser->execute([
            $id
        ]);

        $resultUser = $queryGetUser->fetch();

        return $resultUser;
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

    //FONCTION AJOUT D'UN UTILISATEUR
    function addUser($informations)
    {
        $db = dbConnect(); //Connexion

        //Si elle est false cela veut dire que l'email n'est pas utilisée
        if(!checkEmailAlreadyUsed($informations['email'])){

            //Ajout des valeurs de l'user
            $query = $db->prepare("INSERT INTO users (lastname, firstname, email, password) VALUES (?, ?, ?, ?)");
            $result = $query->execute([
                $informations['lastname'],
                $informations['firstname'],
                $informations['email'],
                hash('md5', $informations['password']) //on hash le mot de passe pour le proteger
            ]);

            $newIdUser = $db->lastInsertId();

            //on stocke ses infos dans une session user pour les utiliser ensuite
            $_SESSION['user'] = [
                'id' => $newIdUser,
                'firstname' => $informations['firstname'],
                'lastname' => $informations['lastname'],
                'email' => $informations['email'],
                'is_admin' => 0,
                'phone' => ""
            ];

            return [$result, false]; //on retourne le resultat de la query (si ça s'est bien passé ou non) ainsi que false pour indiquer qu'il n'y a pas eu d'erreur d'email déjà utilisée

        }else{
            return [false, true]; //on retourne faux pour indiquer qu'il y a une erreur et true car l'adresse mail existe déjà
        }
    }

    //FONCTION DE CONNEXION D'UN UTILISATEUR
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

    //FONCTION UPDATE DES INFOS D'UN UTILISATEUR
    function updateUserProfile($informations, $id){

        $db = dbConnect();

        //String qui contiendra la requete finale en fonction des choix de l'user
        $contentQuery = "";

        $arrayKeys = ['lastname', 'firstname', 'email', 'password', 'phone']; //array qui contient les clés

        //ici on vérifie le typage de certain champ (phone qui ne doit pas contenir de lettre) et email qui ne doit pas etre utilisée)
        foreach ($arrayKeys as $arrayKey){
            if(!empty($informations[$arrayKey])){
                switch($arrayKey){
                    case 'phone':
                        if(!is_numeric($informations[$arrayKey])){ //on vérifie si le numéro est bien un numérique
                            return [false, false, true];
                        }
                        break;
                    case 'email':
                        //on vérifie si l'email modifiée n'est pas déjà utilisée
                        $email = checkEmailAlreadyUsed($informations[$arrayKey]);
                        if($email && $email['id'] != $id) //si elle est déjà utilisée par un autre user que lui meme
                            return [false, true, false]; //on retourne false puisqu'il n'y a pas eu de retour de query et true puisqu'il y a une erreur du l'email
                        break;
                }
            }
        }

        //2 ints qui nous serviront a générer la requete en fonction des valeurs modifiées de l'user
        $numberOfActualModifiedValues = 0; //nombre de valeur modifiée actuelle (quand on sera dans la boucle for)
        $lastModifiedValueInArray = 0; //Int qui contiendra le dernier id de l'input modifié

        //String qui contiendra l'execute en fonction de la requete finale
        $queryExecuteString = "";

        //Pour chaque input du profil, on vérifie si il a été modifié et si oui on met un 1 dans l'array, 0 sinon
        for($i = 0; $i < sizeof($informations); $i++){
            if(!empty($informations[$arrayKeys[$i]])){
                $arrayIsModified[$i] = 1;
                $lastModifiedValueInArray = $i; //on met a jour la valeur max modifiée a chaque fois
            }
            else
                $arrayIsModified[$i] = 0;
        }

        //Génération de la réquete en fonction des valeurs modifiées
        for($i = 0; $i < sizeof($informations); $i++){
            if($arrayIsModified[$i] == 1 && $numberOfActualModifiedValues != $lastModifiedValueInArray){
                $contentQuery .= $arrayKeys[$i] . ' = ?, '; //si la valeur a été modifiée alors on ajoute la clé + " = ?, "
                if($arrayKeys[$i] == "password") //si le champ a 1 est le mdp alors, on le hash
                    $queryExecuteString .= hash('md5', $informations[$arrayKeys[$i]]) . " ";
                else
                    $queryExecuteString .= $informations[$arrayKeys[$i]] . " "; //idem pour la modification du execute en fonction de la requete
            }
            else if($arrayIsModified[$i] == 1 && $numberOfActualModifiedValues == $lastModifiedValueInArray){ //si c'est la dernière valeur modifiée, alors on adapte la requete sans la virgule
                $contentQuery .= $arrayKeys[$i] . ' = ?'; //si la valeur a été modifiée et que c'est la dernière alors on ajoute la clé + " = ? " pour ensuite accueillir le WHERE id = ?
                if($arrayKeys[$i] == "password") //si le dernier champ modifié est le mdp alors, on le hash
                    $queryExecuteString .= hash('md5', $informations[$arrayKeys[$i]]) . " ";
                else
                $queryExecuteString .= $informations[$arrayKeys[$i]] . " ";
            }
            $numberOfActualModifiedValues++; //incrémentation du nombre de value parcourues
        }

        //on ajoute pour fini l'id qui sera toujours a la fin
        $queryExecuteString .= $id;

        //on explose le string pour en faire un array pour ensuite l'envoyer dans l'execute
        $queryFinalExecuteString = explode(" ", $queryExecuteString);

        //String qui contiendra les champs a modifier en fonction des champs modifiés par l'user
        $queryPrepareString = "UPDATE users SET $contentQuery WHERE id = ?";

        $queryUpdateInfos = $db->prepare($queryPrepareString); //preparation de la requete avec le string

        //Execution de la requete avec la string générée en fonction des valeurs modifiées de l'user
        $result = $queryUpdateInfos->execute($queryFinalExecuteString);

        return [$result, false, false]; //on retourne le resultat de la fonction (vrai si les valeurs on été modifiées; faux sinon)

    }