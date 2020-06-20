<?php
    //CONTROLLER INDEX
    //on require tous les models
    require 'models/User.php'; //pour les users
    require 'models/Order.php'; //pour les commandes
    require 'models/Address.php'; //pour les adresses
    require 'models/Category.php'; //pour les catégories
    require 'models/Product.php'; //pour les produits

    //Récupération d'informations totales sur les différentes parties du site (User, Catégories, Produits)
    $numberOfUsers = getNumberOfUsers(); //on récupère le nombre total d'user
    $numberOfCategories = getNumberOfCategories(); //on récupère le nombre total de catégories
    $numberOfProducts = getNumberOfProducts(); //on récupère le nombre total de produits
    $numberOfOrders = getNumberOfOrders(); //on récupère le nombre total de commandes

    $title = 'La Boîte de Concert - Dashboard';
    $view = 'views/index.php';