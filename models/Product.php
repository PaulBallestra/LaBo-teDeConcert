<?php

    //Fonction qui va retourner tous les produits (salles, theatres, ...)
    function getProducts()
    {
        $selectedProducts = []; //Création du tableau vide qui contiendra tous les produits du site

        $selectedProducts = dbConnect()->query('SELECT * FROM products ORDER BY name')->fetchAll(); //On récupère tous les produits depuis la bd

        return $selectedProducts; //On retourne le tableau de tous les produits
    }
