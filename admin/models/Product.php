<?php
    //MODELS DES PRODUITS

    //FONCTION QUI NOUS RETOURNE LE NOMBRE TOTAL DE PRODUITS
    function getNumberOfProducts()
    {
        $db = dbConnect();

        $queryNumberOfProducts = $db->query("SELECT COUNT(id) as numberOfProducts FROM products");
        $numberOfProducts = $queryNumberOfProducts->fetch();
        $queryNumberOfProducts->closeCursor();

        return $numberOfProducts['numberOfProducts'];
    }

    //FONCTION QUI RENVOIT TOUS LES PRODUITS
    function getProducts()
    {
        $db = dbConnect();

        $queryGetProducts = $db->query('SELECT * FROM products');
        $resultProducts = $queryGetProducts->fetchAll();

        return $resultProducts;
    }