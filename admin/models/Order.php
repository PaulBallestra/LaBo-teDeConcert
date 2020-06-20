<?php
    //MODEL DES COMMANDES

    //FONCTION QUI VA RETOURNER TOUTES LES COMMANDES
    function getOrders()
    {
        $db = dbConnect();

        $queryGetOrders = $db->query('SELECT * FROM orders');
        $resultOrders = $queryGetOrders->fetchAll();

        return $resultOrders;
    }

    //FUNCTION QUI VA RETOURNER UNE COMMANDE EN PARTICULIER
    function getOrder($id)
    {
        $db = dbConnect();

        $queryGetOrder = $db->prepare('
            SELECT O.*, OD.*
            FROM orders O
            INNER JOIN order_details OD ON OD.id_order = O.id
            WHERE O.id = ?
        ');

        $queryGetOrder->execute([
            $id
        ]);

        return $queryGetOrder->fetch();
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

    //FUNCTION QUI RETOURNE LE NOMBRE TOTAL DE COMMANDES
    function getNumberOfOrders()
    {
        $db = dbConnect();

        $queryGetOrders = $db->query('SELECT COUNT(id) as numberOfOrders FROM orders');
        $numberOfOrders = $queryGetOrders->fetch();
        $queryGetOrders->closeCursor();

        return $numberOfOrders['numberOfOrders'];
    }