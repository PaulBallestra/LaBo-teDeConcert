<?php
    //MODEL DES USERS

    //FONCTION QUI VA CHOPER LE NOMBRE TOTAL D'USERS
    function getNumberOfUsers()
    {
        $db = dbConnect();

        $queryNumberOfUsers = $db->query("SELECT COUNT(id) as numberOfUsers FROM users");
        $numberOfUsers = $queryNumberOfUsers->fetch();
        $queryNumberOfUsers->closeCursor();

        return $numberOfUsers;

    }