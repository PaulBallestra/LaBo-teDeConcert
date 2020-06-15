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

    //Fonction qui va retourner toutes les catégories par ordre alphabétique
    function getCategories()
    {
        $db = dbConnect();

        $selectedCategories = $db->query('SELECT * FROM categories ORDER BY name')->fetchAll(); //On récupère toutes les catégories depuis la bd

        return $selectedCategories; //on retourne la liste des catégories
    }

