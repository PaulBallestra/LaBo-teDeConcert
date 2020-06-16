<?php
    //MODELS DES CATEGORIES

    //FONCTION QUI VA RETOURNER UNE CATEGORIE SPECIFIQUE EN FONCTION DE SON ID
    function getCategory($id)
    {
        $db = dbConnect();

        $queryGetCategory = $db->prepare('SELECT * FROM categories WHERE id = ?');
        $queryGetCategory->execute([
            $id
        ]);

        return $queryGetCategory->fetch();
    }

    //FONCTION QUI VA RETOURNER TOUTES LES CATEGORIES
    function getCategories()
    {
        $db = dbConnect();

        $queryAllCategories = $db->query('SELECT * FROM categories');
        $resultCategories = $queryAllCategories->fetchAll();

        return $resultCategories;
    }

    //FONCTION QUI VA PUSH DANS LA BD UNE NOUVELLE CATEGORIE
    function addCategory($informations)
    {
        $db = dbConnect();

        if(empty($informations['categoryName']) || empty($informations['categoryDescription'])){
            return [false, true]; //on renvoit que tous les champs sont obligatoires
        }

        //Query qui va push dans la base de donnée, le nom et la description de la nouvelle catégorie
        $queryAddCategory = $db->prepare('INSERT INTO categories (name, description) VALUES (?, ?)');
        $resultAddCategory = $queryAddCategory->execute([
            $informations['categoryName'],
            $informations['categoryDescription']
        ]);

        //Si ça s'est bien passé, on ajoute l'image
        if($resultAddCategory){
            $categoryId = $db->lastInsertId(); //retourne l'id de la dernière ligne insérée
            insertCategoryImage($categoryId); //on appele ensuite la fonction d'ajout d'une image
        }

        return $resultAddCategory;
    }

    //FONCTION QUI VA UPDATE UNE CATEGORIE EN FOONCTION DE SON ID
    function updateCategory($id, $informations)
    {
        $db = dbConnect();

        var_dump($informations);

        //on check tous les champs
        if(empty($informations['categoryName']) || empty($informations['categoryDescription']) || empty($informations['categoryImage'])){
            return [false, true]; //on renvoit que tous les champs sont obligatoires
        }

        //Query qui va update dans la base de donnée, le nom et la description de la catégorie selectionnée
        $queryUpdateCategory = $db->prepare('UPDATE categories SET name = ?, description = ? WHERE id = ?');
        $resultUpdateCategory = $queryUpdateCategory->execute([
            $informations['categoryName'],
            $informations['categoryDescription'],
            $id
        ]);

        //si ça s'est bien passé, on met a jour l'image
        if($resultUpdateCategory)
            insertCategoryImage($id);

        return $resultUpdateCategory;
    }

    //FONCTION QUI VA AJOUTER UNE IMAGE A UNE CATEGORIE
    function insertCategoryImage($categoryId)
    {
        $db = dbConnect();

        $resultUploadImg = false;

        var_dump($categoryId);
        var_dump($_FILES);

        if(!empty($_FILES['categoryImage']['tmp_name'])) { //Si il a selectionné un fichier

            //on vire l'ancienne image si il y en a une (quand on utilise la fonction en update)
            if(getCategory($categoryId)['image'] != null)
                unlink('../assets/images/categories/' . getCategory($categoryId)['image']);

            $allowed_extensions = array('jpg', 'png', 'jpeg', 'gif');
            $my_file_extension = pathinfo($_FILES['categoryImage']['name'], PATHINFO_EXTENSION);

            if (in_array($my_file_extension, $allowed_extensions)) {

                $new_file_name = $categoryId . '.' . $my_file_extension;
                $destination = '../assets/images/categories/' . $new_file_name;
                $resultUploadImg = move_uploaded_file($_FILES['categoryImage']['tmp_name'], $destination);

                //update du nom de l'image de l'enregistrement d'id
                $query = $db->query("UPDATE categories SET image = '$new_file_name' WHERE id = $categoryId");

                return $query;
            }
        }

        return $resultUploadImg;
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

    //FONCTION QUI VA RETOURNER LE NOMBRE TOTAL DE CATEGORIES
    function getNumberOfCategories()
    {
        $db = dbConnect();

        $queryNumberOfCategories = $db->query("SELECT COUNT(id) as numberOfCategories FROM categories");
        $numberOfCategories = $queryNumberOfCategories->fetch();
        $queryNumberOfCategories->closeCursor();

        return $numberOfCategories['numberOfCategories'];
    }