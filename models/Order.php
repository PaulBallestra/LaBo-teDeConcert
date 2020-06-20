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
    function setOrderDetails($idOrder, $informationsProduct, $informationsUser)
    {
        $db = dbConnect();

        $stringProduct = implode("/", $informationsProduct);
        $stringUser = implode("/", $informationsUser);

        $querySetOrderDetails = $db->prepare('INSERT INTO order_details (id_order, product, quantity, user) VALUES (?, ?, ?, ?)');
        $querySetOrderDetails->execute([
            $idOrder,
            $stringProduct,
            $informationsProduct['quantity'],
            $stringUser
        ]);

        return $querySetOrderDetails;
    }

    //FONCTION QUI VA RETOURNE LES ID DES COMMANDES D'UN USER
    function getOrders($idUser)
    {
        $db = dbConnect();

        $queryGetOrders = $db->prepare('SELECT * FROM orders WHERE id_user = ?');
        $queryGetOrders->execute([
            $idUser
        ]);


        return $queryGetOrders->fetchAll();
    }

    //FUNCTION QUI VA RETOURNER LES DETAILS D'UNE COMMANDE D'ID EN PARAMETRE
    function getDetailsOfOrder($id)
    {
        $db = dbConnect();

        $queryGetDetails = $db->prepare('SELECT * FROM order_details WHERE id_order = ?');
        $queryGetDetails->execute([
            $id
        ]);

        return $queryGetDetails->fetchAll();
    }