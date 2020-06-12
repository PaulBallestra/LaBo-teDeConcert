<?php
    //MODEL DES ADDRESS

    //FUNCTION QUI VA NOUS RETOURNER UNE ADRESSE EN FONCTION DE L'ID D'UN USER (si $isUser est vrai) OU EN FONCTION D'UN PRODUIT (si $isUser est faux)
    function getAddress($id, $isUser){

        $db = dbConnect();

        //en fonction de si c'est un user ou un produit, on adapte la query
        $isUser ? $idChoosen = 'id_user' : $idChoosen = 'id_product';

        $queryGetAddress = $db->prepare("SELECT * FROM addresses WHERE " . $idChoosen . " = ?");

        $queryGetAddress->execute([
            $id
        ]);

        return ($queryGetAddress->fetch());

    }

    //FONCTION QUI RETOURNE VRAI SI L'ADRESSE EST DEJA EXISTANTE POUR UN CERTAIN USER
    function checkAddressAlreadySet($id)
    {
        $db = dbConnect();

        $queryTestAddress = $db->prepare("SELECT id FROM addresses WHERE id_user = ?");
        $queryTestAddress->execute([
           $id
        ]);

        $addressAlreadySet = $queryTestAddress->fetch();

        return $addressAlreadySet;
    }

    //FONCTION QUI VA AJOUTER UNE ADRESSE POUR UN USER DONNÉ
    function addUserAddress($informations, $id)
    {
        $db = dbConnect();

        var_dump($informations);

        //SOn vérifie qu'il n'y ait aucuns champs vides
        if(empty($informations['addressNumber']) || empty($informations['addressStreet']) || empty($informations['addressTown']) || empty($informations['addressPostal']) || empty($informations['addressCountry'])) {
            //on renvoit une erreur
            return [false, true, false]; //on renvoit vrai dans le 1 du return pour indiquer au controller qu'il y a des champs vides, false apres pour indiquer qu'il n'y a pas d'erreur de nombre (code postal ou numéro)

        }
        //si tous les champs sont bien remplis

        //Préparation de l'insertion
        $queryAddUserAddress = $db->prepare("INSERT INTO addresses (number, street, town, postal_code, country, id_user) VALUES (?, ?, ?, ?, ?, ?)");

        //Execution de la query
        $result = $queryAddUserAddress->execute([
            $informations['addressNumber'],
            $informations['addressStreet'],
            $informations['addressTown'],
            $informations['addressPostal'],
            $informations['addressCountry'],
            $id
        ]);

        return [$result, false, false]; //retournement avec un false en 1 pour indiquer qu'il n'y a pas eu d'erreur de champs et false en 2 pour indiquer qu'il n'y a pas eu non plus d'erreur de nombre
    }

    //FONCTION QUI VA METTRE A JOUR UNE L'ADRESSE D'UN USER DONNÉ
    function updateUserAddress($informations, $id)
    {
        $db = dbConnect();

        //on teste pour voir si il a déjà une adresse liée
        if(!checkAddressAlreadySet($id)){ //si ce n'est pas le cas ou va la créer directement
            $resultUpdatedAddress = addUserAddress($informations, $id); //appel de la création d'une nouvelle addresse

            return [$resultUpdatedAddress, false, false];

        }else{

            //On vérifie qu'il n'y ait aucuns champs vides
            if(empty($informations['addressNumber']) || empty($informations['addressStreet']) || empty($informations['addressTown']) || empty($informations['addressPostal']) || empty($informations['addressCountry'])) {
                //on renvoit une erreur
                return [false, true, false]; //on renvoit vrai dans le 1 du return pour indiquer au controller qu'il y a des champs vides
            }

            //vérification du champs number et code postal qui ne doivent etre que des nombres
            if(!is_numeric($informations['addressNumber']) || !is_numeric($informations['addressPostal'])){
                return [false, false, true]; //on renvoit false, false, et true ppour indiquer qu'il y a un problème avec le numéro ou le code postal
            }

            //sinon on prepare la requete de mise a jour
            $queryUpdateUserAddress = $db->prepare("UPDATE addresses SET number = ?, street = ?, town = ?, postal_code = ?, country = ? WHERE id_user = ?");

            //execution de la requete
            $resultUpdatedAddress = $queryUpdateUserAddress->execute([
                $informations['addressNumber'],
                $informations['addressStreet'],
                $informations['addressTown'],
                $informations['addressPostal'],
                $informations['addressCountry'],
                $id
            ]);

            return [$resultUpdatedAddress, false, false];
        }
    }
