<?php
    //MODELS DES PANIERS

    //FONCTION QUI VA CREER UN CART A UN USER LORS DE SON INSCRIPTION
    function createCart($idUser)
    {
        $db = dbConnect();

        $queryCreateCart = $db->prepare('INSERT INTO carts (id_user) VALUES (?)');
        $queryCreateCart->execute([
            $idUser
        ]);

        return $queryCreateCart;
    }

    //FONCTION QUI RENVOIT L'ID DU CART DE L'USER
    function getIdCartOfUser($idUser)
    {
        $db = dbConnect();

        $queryGetIdCart = $db->query('SELECT id FROM carts WHERE id_user = ' . $idUser);
        return $queryGetIdCart->fetch()['id'];
    }