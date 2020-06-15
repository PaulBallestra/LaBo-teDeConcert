<?php

    //FONCTION QUI VA RETOURNER UN PRODUIT UNIQUE EN FONCTION DE SON ID
    function getProduct($id)
    {
        $db = dbConnect();

        $queryGetProduct = $db->prepare('SELECT * FROM products WHERE id = ?');
        $queryGetProduct->execute([
            $id //id du produit selectionné
        ]);


    }

    //FONCTION QUI RETOURNE TOUS LES PRODUITS DISPONIBLES
    function getProducts()
    {
        $db = dbConnect();

        $selectedProducts = $db->query('SELECT * FROM products ORDER BY name')->fetchAll(); //On récupère tous les produits depuis la bd que l'on stocke dans selectedProducts

        return $selectedProducts; //On retourne le tableau de tous les produits
    }
