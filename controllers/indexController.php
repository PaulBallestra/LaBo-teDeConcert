<?php

    //On indique qu'on a besoin des models des Categories et des Produits
    require_once 'models/Category.php';
    require_once 'models/Product.php';
    require_once 'models/User.php';

    $categories = getCategories();

    $title = "La Boîte de Concert - Accueil";
    $view = 'views/index.php';
