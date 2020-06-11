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

    //Fonctio qui va modifier les valeurs d'un user (nom, prenom, telephone, email, mdp, et adresse)
    function updateUserProfile($informations, $id){

        $db = dbConnect();

        //String qui contiendra la requete finale en fonction des choix de l'user
        $contentQuery = "(";

        $arrayKeys = ['lastname', 'firstname', 'email', 'password', 'phone']; //array qui contient les clés

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
                $contentQuery .= $arrayKeys[$i] . ' = ?, ';
                $queryExecuteString .= "\$informations['$arrayKeys[$i]'],\n"; //idem pour la modification du execute en fonction de la requete
            }
            else if($arrayIsModified[$i] == 1 && $numberOfActualModifiedValues == $lastModifiedValueInArray){ //si c'est la dernière valeur modifiée, alors on adapte la requete sans la virgule
                $contentQuery .= $arrayKeys[$i] . ' = ?';
                $queryExecuteString .= "\$informations['$arrayKeys[$i]'],\n";
            }
            $numberOfActualModifiedValues++;
        }

        $contentQuery .= ")"; //on ferme la requete

        //on ajoute l'id dans le string de l'execute de la requete
        $queryExecuteString .= "\$id";

        //String qui contiendra les champs a modifier en fonction des champs modifiés par l'user
        $queryPrepareString = "UPDATE user SET $contentQuery WHERE id = ?";

        $queryUpdateInfos = $db->prepare($queryPrepareString); //preparation de la requete avec le string

        //Execution de la requete avec la string générée en fonction des valeurs modifiées de l'user
        $result = $queryUpdateInfos->execute($queryExecuteString);

        return $result;

    }