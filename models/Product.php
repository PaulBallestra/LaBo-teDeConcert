<?php

    //FONCTION QUI VA RETOURNER UN PRODUIT UNIQUE EN FONCTION DE SON ID
    function getProduct($id)
    {
        $db = dbConnect();

        $queryGetProduct = $db->prepare('SELECT * FROM products WHERE id = ?');
        $queryGetProduct->execute([
            $id //id du produit selectionné
        ]);

        return $queryGetProduct->fetch();

    }

    //FONCTION QUI RETOURNE TOUS LES PRODUITS DISPONIBLES
    function getProducts()
    {
        $db = dbConnect();

        $selectedProducts = $db->query('SELECT * FROM products ORDER BY name')->fetchAll(); //On récupère tous les produits depuis la bd que l'on stocke dans selectedProducts

        return $selectedProducts; //On retourne le tableau de tous les produits
    }

    //FONCTION QUI RETOURNE TOUS LES PRODUITS EN FONCTION DE LA CATEGORIE SELECTIONNÉE
    function getProductsByCategory($idCategory)
    {
        $db = dbConnect();

        /* Jointure qui chopera tous les produits inclus dans une catégories précise */
        $queryGetProductsByCategory = $db->prepare("
            SELECT P.*
            FROM categories C
            INNER JOIN product_categories PC ON C.id = PC.id_category
            INNER JOIN products P ON PC.id_product = P.id
            WHERE c.id = ?
        ");

        $queryGetProductsByCategory->execute([
            $idCategory
        ]);

        $resultGetProductsByCategory = $queryGetProductsByCategory->fetchAll();

        return $resultGetProductsByCategory;

    }

    //FONCTION QUI RETOURNE VRAI SI UN PRODUIT EXISTE EN FONCTION DE SON ID
    function checkProductExists($id)
    {
        $db = dbConnect();

        $queryCheckProduct = $db->prepare('SELECT id FROM products WHERE id = ?');
        $queryCheckProduct->execute([
            $id
        ]);

        return $queryCheckProduct->fetch();
    }