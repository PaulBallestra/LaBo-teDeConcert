<?php

    //FONCTION QUI RETOURNE UNE CATEGORIE EN PARTICULIER EN FONCTION DE SON ID
    function getCategory($id)
    {
        $db = dbConnect();

        $queryGetCategory = $db->prepare('SELECT * FROM categories WHERE id = ?');
        $queryGetCategory->execute([
            $id
        ]);

        return $queryGetCategory->fetch();

    }

    //FONCTION QUI RETOURNE TOUTES LES CATEGORIES RANGEE PAR ORDRE ALPHABETIQUE
    function getCategories()
    {
        $db = dbConnect();

        $selectedCategories = $db->query('SELECT * FROM categories ORDER BY name')->fetchAll(); //On récupère toutes les catégories depuis la bd

        return $selectedCategories; //on retourne la liste des catégories
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

