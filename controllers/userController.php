<?php
    //CONTROLER DE L'USER

    //On vérifie qu'il y a bien un post envoyé
    if(isset($_GET['page'])){

        switch($_GET['page']){

            case 'profil': //dans le cas ou il veut afficher sa page de profil
                $title = "La Boîte de Concert - Votre Profil";
                $view = 'views/profil.php';
                break;

            case 'update': //dans le cas ou l'user veut modifier des informations de son compte
                $title = "La Boîte de Concert - Modification Profil";
                $view = 'views/update_profil.php';
                break;

            case 'delete': //dans le cas ou l'user veut supprimer son compte
                $title = "La Boîte de Concert - Suppresion Profil";
                $view = 'views/delete_profil.php';
                break;

        }

    }