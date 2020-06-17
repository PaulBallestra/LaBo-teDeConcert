<?php
    //MODELS DES PRODUITS

    //FONCTION QUI VA AJOUTER UN PRODUIT
    function addProduct($informations)
    {
        $db = dbConnect();

        //vérification des champs non vide
        if(empty($informations['productName']) || empty($informations['productDescription']) || empty($informations['productCapacity']) || empty($informations['productPrice']) || $informations['productImages']['size'] == 0 || empty($informations['categoriesId']) || empty($informations['productAddressNumber']) || empty($informations['productAddressStreet'])
            || empty($informations['productAddressTown']) || empty($informations['productAddressPostalCode']) || empty($informations['productAddressCountry'])){
            return [false, true]; //on renvoit que tous les champs sont obligatoires
        }

        $queryAddProduct = $db->prepare('INSERT INTO products (name, description, capacity, price) VALUES (?, ?, ?, ?)');
        $resultAddProduct = $queryAddProduct->execute([
            $informations['productName'],
            $informations['productDescription'],
            $informations['productCapacity'],
            $informations['productPrice'],
        ]);

        if($resultAddProduct){

            //on récupère la derniere instance créée dans la bd
            $productId = $db->lastInsertId();

            //on ajoute les liens entre les catégories choisies et le produit,
            for($i = 0; $i < sizeof($informations['categoriesId']); $i++){
                $queryAddProductToCategory = $db->prepare('INSERT INTO product_categories (id_product, id_category) VALUES (?, ?)');
                $queryAddProductToCategory->execute([
                    $productId,
                    $informations['categoriesId'][$i]
                ]);
            }

            //on enregistre l'addresse du produit
            $queryAddAddress = $db->prepare('INSERT INTO addresses (number, street, town, postal_code, country, id_product) VALUES (?, ?, ?, ?, ?, ?)');
            $queryAddAddress->execute([
                $informations['productAddressNumber'],
                $informations['productAddressStreet'],
                $informations['productAddressTown'],
                $informations['productAddressPostalCode'],
                $informations['productAddressCountry'],
                $productId
            ]);

            //on ajoute ensuite l'image
            insertProductImages($productId);

        }

        return $resultAddProduct;
    }

    //FONCTION QUI NOUS RETOURNE LE NOMBRE TOTAL DE PRODUITS
    function getNumberOfProducts()
    {
        $db = dbConnect();

        $queryNumberOfProducts = $db->query("SELECT COUNT(id) as numberOfProducts FROM products");
        $numberOfProducts = $queryNumberOfProducts->fetch();
        $queryNumberOfProducts->closeCursor();

        return $numberOfProducts['numberOfProducts'];
    }

    //FONCTION QUI RENVOIT TOUS LES PRODUITS
    function getProducts()
    {
        $db = dbConnect();

        $queryGetProducts = $db->query('SELECT * FROM products');
        $resultProducts = $queryGetProducts->fetchAll();

        return $resultProducts;
    }

    //FONCTION QUI RENVOIT UN PRODUIT EN PARTICULIER EN FONCTION DE SON ID
    function getProduct($id)
    {
        $db = dbConnect();

        $queryAddProduct = $db->prepare('SELECT * FROM products WHERE id = ?');
        $queryAddProduct->execute([
            $id
        ]);

        return $queryAddProduct->fetch();
    }

    //FONCTION QUI VA AJOUTER DES IMAGES A UN PRODUIT
    function insertProductImages($productId)
    {
        $db = dbConnect();

        $resultUploadImg = false;

        if(!empty($_FILES['productImages']['tmp_name'])) { //Si il a selectionné un fichier

            //on check si l'image n'est pas supérieure à 2mo, sinon on retourne faux
            //if(filesize($_FILES['categoryImage']['tmp_name'])/1000 > 2)
            //    return false;

            //on vire l'ancienne image si il y en a une (quand on utilise la fonction en update)
            if(getProduct($productId)['images'] != null)
                unlink('../assets/images/products/' . getProduct($productId)['images']);

            $allowed_extensions = array('jpg', 'png', 'jpeg', 'gif');
            $my_file_extension = pathinfo($_FILES['productImages']['name'], PATHINFO_EXTENSION);

            if (in_array($my_file_extension, $allowed_extensions)) {

                $new_file_name = $productId . '.' . $my_file_extension;
                $destination = '../assets/images/products/' . $new_file_name;
                $resultUploadImg = move_uploaded_file($_FILES['productImages']['tmp_name'], $destination);

                //update du nom de l'image de l'enregistrement d'id
                $query = $db->query("UPDATE products SET images = '$new_file_name' WHERE id = $productId");

                return $query;
            }
        }

        return $resultUploadImg;
    }

    //FONCTION QUI VA SUPPRIMER UN PRODUIT EN FONCTION DE SON ID
    function deleteProduct($id)
    {
        $db = dbConnect();

        //si il a des images, on les supprime avant de le supprimer complement
        if(getProduct($id)['images'] != null)
            unlink('../assets/images/products/' . getProduct($id)['images']);

        //on supprime également les liens entre le produit et les catégories
        $queryDeleteLinkCategory = $db->prepare('DELETE FROM product_categories WHERE id_product = ?');
        $queryDeleteLinkCategory->execute([
            $id
        ]);

        //on supprime l'addresse du produit
        $queryDeleteLinkAddress = $db->prepare('DELETE FROM addresses WHERE id_product = ?');
        $queryDeleteLinkAddress->execute([
            $id
        ]);

        $queryDeleteProduct = $db->prepare('DELETE FROM products WHERE id = ?');
        $queryDeleteProduct->execute([
            $id
        ]);

        return $queryDeleteProduct;
    }