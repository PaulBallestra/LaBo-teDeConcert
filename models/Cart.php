<?php
    //MODELS DES PANIERS

    //FONCTION QUI VA AJOUTER UN CART A UN USER LORS DE SON INSCRIPTION
    function createCart($idUser)
    {
        $db = dbConnect();

        $queryCreateCart = $db->prepare('INSERT INTO carts (id_user) VALUES (?)');
        $queryCreateCart->execute([
            $idUser
        ]);

        return $queryCreateCart;
    }

    //FONCTION QUI VA RETOURNER TOUS LES PRODUITS (ID) D'UN PANIER EN FONCTION D'UN USER
    function getProductsCart($idUser)
    {
        $db = dbConnect();

        $queryGetProductsCart = $db->prepare('
                SELECT PC.id_product
                FROM products_cart PC
                INNER JOIN carts C ON C.id = PC.id_cart
                WHERE C.id_user = ?');

        $queryGetProductsCart->execute([
            $idUser
        ]);

        return $queryGetProductsCart->fetchAll();
    }

    //FONCTION QUI RENVOIT L'ID DU CART DE L'USER
    function getIdCartOfUser($idUser)
    {
        $db = dbConnect();

        $queryGetIdCart = $db->query('SELECT id FROM carts WHERE id_user = ' . $idUser);
        return $queryGetIdCart->fetch()['id'];
    }