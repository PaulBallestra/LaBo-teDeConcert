<?php

    //Fonction qui va retourner toutes les catégories par ordre alphabétique
    function getCategories()
    {
        $selectedCategories = []; //Création d'un tableau de categories qui va stocker toutes les catégories

        $selectedCategories = dbConnect()->query('SELECT * FROM categories ORDER BY name')->fetchAll(); //On récupère toutes les catégories depuis la bd

        return $selectedCategories; //on retourne la liste des catégories
    }

