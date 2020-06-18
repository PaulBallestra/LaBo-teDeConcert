<?php
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