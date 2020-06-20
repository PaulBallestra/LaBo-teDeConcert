<?php
    //MODELS DES COMMANDES

    //FONCTION QUI VA AJOUTER UNE COMMANDE A UN USER
    function addOrder($idUser, $price)
    {
        $db = dbConnect();

        $queryAddOrder = $db->prepare('INSERT INTO orders (id_user, price) VALUES (?, ?)');
        $queryAddOrder->execute([
            $idUser,
            $price
        ]);

        return $db->lastInsertId();
    }

    //FUNCTION QUI VA AJOUTER LES PRODUITS DE LA COMMANDE NUM id
    function setOrderDetails($idOrder, $informations)
    {
        $db = dbConnect();

        $stringProduct = implode("/", $informations);

        $querySetOrderDetails = $db->prepare('INSERT INTO order_details (id_order, product, quantity) VALUES (?, ?, ?)');
        $querySetOrderDetails->execute([
            $idOrder,
            $stringProduct,
            $informations['quantity']
        ]);

        return $querySetOrderDetails;
    }