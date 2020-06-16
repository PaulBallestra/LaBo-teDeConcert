<?php
    //MODEL DES USERS

    //FONCTION QUI VA CHOPER LE NOMBRE TOTAL D'USERS
    function getNumberOfUsers()
    {
        $db = dbConnect();

        $queryNumberOfUsers = $db->query("SELECT COUNT(id) as numberOfUsers FROM users");
        $numberOfUsers = $queryNumberOfUsers->fetch();
        $queryNumberOfUsers->closeCursor();

        return $numberOfUsers['numberOfUsers'];
    }

    //FONCTION QUI VA RETOURNER TOUS LES USERS
    function getUsers()
    {
        $db = dbConnect();

        $queryGetUsers = $db->query('SELECT * FROM users');
        $resultUsers = $queryGetUsers->fetchAll();

        return $resultUsers;
    }
