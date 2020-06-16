<?php
    //MODELS DES CATEGORIES

    //FONCTION QUI VA RETOURNER UNE CATEGORIE SPECIFIQUE EN FONCTION DE SON ID
    function getCategory($id)
    {
        $db = dbConnect();

        $queryGetCategory = $db->prepare('SELECT * FROM categories WHERE id = ?');
        $queryGetCategory->execute([
            $id
        ]);

        return $queryGetCategory->fetch();
    }

    //FONCTION QUI VA RETOURNER TOUTES LES CATEGORIES
    function getCategories()
    {
        $db = dbConnect();

        $queryAllCategories = $db->query('SELECT * FROM categories');
        $resultCategories = $queryAllCategories->fetchAll();

        return $resultCategories;
    }

    //FONCTION QUI VA RETOURNER VRAI SI UNE CERTAINE CATEGORIE EXISTE
    function checkCategoryExists($id)
    {
        $db = dbConnect();

        $queryCheckCategory = $db->prepare('SELECT id FROM categories WHERE id = ?');
        $queryCheckCategory->execute([
            $id
        ]);

        return $queryCheckCategory->fetch();
    }

    //FONCTION QUI VA RETOURNER LE NOMBRE TOTAL DE CATEGORIES
    function getNumberOfCategories()
    {
        $db = dbConnect();

        $queryNumberOfCategories = $db->query("SELECT COUNT(id) as numberOfCategories FROM categories");
        $numberOfCategories = $queryNumberOfCategories->fetch();
        $queryNumberOfCategories->closeCursor();

        return $numberOfCategories['numberOfCategories'];
    }