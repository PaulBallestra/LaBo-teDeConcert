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

    //FONCTION QUI RENVOIT TOUTES LES CATEGORIES D'UN PRODUIT
    function checkCategoryOfProduct($idProduct, $idCategory)
    {
        $db = dbConnect();

        $querySelectedCategories = $db->prepare('
            SELECT C.id
            FROM categories C
            INNER JOIN product_categories PC ON C.id = PC.id_category
            WHERE PC.id_product = ?
            AND PC.id_category = ?');

        $querySelectedCategories->execute([
            $idProduct,
            $idCategory
        ]);

        return $querySelectedCategories->fetch();
    }

    //FONCTION QUI VA PUSH DANS LA BD UNE NOUVELLE CATEGORIE
    function addCategory($informations)
    {
        $db = dbConnect();

        if(empty($informations['categoryName']) || empty($informations['categoryDescription']) || $informations['categoryImage']['size'] == 0){
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

        //on check tous les champs
        if(empty($informations['categoryName']) || empty($informations['categoryDescription'])){
            return [false, true]; //on renvoit que tous les champs sont obligatoires
        }

        //Query qui va update dans la base de donnée, le nom et la description de la catégorie selectionnée
        $queryUpdateCategory = $db->prepare('UPDATE categories SET name = ?, description = ? WHERE id = ?');
        $resultUpdateCategory = $queryUpdateCategory->execute([$informations['categoryName'],
            $informations['categoryDescription'],
            $id
        ]);

        //si l'image aussi a été updatée, on la met a jour
        if(!empty($informations['categoryImage']['name']))
            insertCategoryImage($id); //mis a jour de l'image

        return $resultUpdateCategory;
    }

    //FONCTION QUI VA SUPPRIMER UNE CATEGORIE EN FONCTION DE SON ID
    function deleteCategory($id)
    {
        $db = dbConnect();

        $categoryToDelete = getCategory($id); //on recupère la dite catégory pour ensuite supprimer l'image qui va avec

        if($categoryToDelete['image'] != null)
            unlink('../assets/images/categories/'.$categoryToDelete['image']);

        $queryDeleteCategory = $db->prepare('DELETE FROM categories WHERE id = ?');
        $queryDeleteCategory->execute([
            $id
        ]);

        //suppresion des liens entre la catégories et les produits
        $queryDeleteLinkOfProducts = $db->prepare('DELETE FROM product_categories WHERE id_category = ?');
        $queryDeleteLinkOfProducts->execute([
            $id
        ]);

        return $queryDeleteCategory;

    }

    //FONCTION QUI VA AJOUTER UNE IMAGE A UNE CATEGORIE
    function insertCategoryImage($categoryId)
    {
        $db = dbConnect();

        $resultUploadImg = false;

        if(!empty($_FILES['categoryImage']['tmp_name'])) { //Si il a selectionné un fichier

            //on check si l'image n'est pas supérieure à 2mo, sinon on retourne faux
            //if(filesize($_FILES['categoryImage']['tmp_name'])/1000 > 2)
            //    return false;

            //on vire l'ancienne image si il y en a une (quand on utilise la fonction en update)
            if(!empty(getCategory($categoryId)['image']))
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