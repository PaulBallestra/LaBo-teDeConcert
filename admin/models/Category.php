<?php
    //MODELS DES CATEGORIES

    //FONCTION QUI VA RETOURNER LE NOMBRE TOTAL DE CATEGORIES
    function getNumberOfCategories()
    {
        $db = dbConnect();

        $queryNumberOfCategories = $db->query("SELECT COUNT(id) as numberOfCategories FROM categories");
        $numberOfCategories = $queryNumberOfCategories->fetch();
        $queryNumberOfCategories->closeCursor();

        return $numberOfCategories['numberOfCategories'];

    }

    //FONCTION QUI VA RETOURNER TOUTES LES CATEGORIES
    function getCategories()
    {
        $db = dbConnect();

        $queryAllCategories = $db->query('SELECT * FROM categories');
        $resultCategories = $queryAllCategories->fetchAll();

        return $resultCategories;
    }
