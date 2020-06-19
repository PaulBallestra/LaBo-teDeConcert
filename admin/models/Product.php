<?php
    //MODELS DES PRODUITS

    //FONCTION QUI VA AJOUTER UN PRODUIT
    function addProduct($informations)
    {
        $db = dbConnect();

        //vérification des champs non vide
        if(empty($informations['productName']) || empty($informations['productDescription']) || empty($informations['productCapacity']) || empty($informations['productPrice']) || $informations['productImage1']['size'] == 0 || $informations['productImage2']['size'] == 0 || $informations['productImage3']['size'] == 0 || empty($informations['categoriesId']) || empty($informations['productAddressNumber']) || empty($informations['productAddressStreet'])
            || empty($informations['productAddressTown']) || empty($informations['productAddressPostalCode']) || empty($informations['productAddressCountry']))
            return [false, true]; //on renvoit que tous les champs sont obligatoires

        //vérification des types des valeurs que l'admin rentre
        if(!ctype_digit($informations['productPrice']) || !ctype_digit($informations['productCapacity']) || !ctype_digit($informations['productAddressNumber']) || !ctype_digit($informations['productAddressPostalCode']))
            return [false, false, true]; //on renvoit true en 3 pour indiquer l'erreur de type

        $allowed_extensions = array('jpg', 'png', 'jpeg', 'gif'); //extensions tolérées pour les images

        if(!in_array(pathinfo($informations['productImage1']['name'], PATHINFO_EXTENSION), $allowed_extensions) || !in_array(pathinfo($informations['productImage2']['name'], PATHINFO_EXTENSION), $allowed_extensions) || !in_array(pathinfo($informations['productImage3']['name'], PATHINFO_EXTENSION), $allowed_extensions))
            return [false, false, false, true]; //on renvoit une erreur sur le type des images

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

        return [$resultAddProduct, false, false, false];
    }

    //FONCTION QUI VA METTRE A JOUR UN PRODUIT EN FONCTION DE SON ID
    function updateProduct($id, $informations)
    {
        $db = dbConnect();


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

        if(!empty($_FILES['productImage1']['tmp_name']) && !empty($_FILES['productImage2']['tmp_name']) && !empty($_FILES['productImage3']['tmp_name'])) { //Si il a selectionné des fichiers

            //on check si l'image n'est pas supérieure à 2mo, sinon on retourne faux
            //if(filesize($_FILES['categoryImage']['tmp_name'])/1000 > 2)
            //    return false;

            //on vire l'ancienne image si il y en a une (quand on utilise la fonction en update)
            if(!empty(getProduct($productId)['images'])){
                $threeImages  = explode(',', getProduct($productId)['images']); //on récupère le tableau de l'explosion du champ images

                unlink('../assets/images/products/' . $threeImages[0]);
                unlink('../assets/images/products/' . $threeImages[1]);
                unlink('../assets/images/products/' . $threeImages[2]);
            }

            //intégrations des images
            $allowed_extensions = array('jpg', 'png', 'jpeg', 'gif');
            $my_file_extension1 = pathinfo($_FILES['productImage1']['name'], PATHINFO_EXTENSION);
            $my_file_extension2 = pathinfo($_FILES['productImage2']['name'], PATHINFO_EXTENSION);
            $my_file_extension3 = pathinfo($_FILES['productImage3']['name'], PATHINFO_EXTENSION);

            if (in_array($my_file_extension1, $allowed_extensions) && in_array($my_file_extension2, $allowed_extensions) && in_array($my_file_extension3, $allowed_extensions)) {

                $new_file_name1 = $productId . '-1.' . $my_file_extension1;
                $new_file_name2 = $productId . '-2.' . $my_file_extension2;
                $new_file_name3 = $productId . '-3.' . $my_file_extension3;

                $queryContent = $new_file_name1 . ',' . $new_file_name2 . ',' . $new_file_name3; //content de la query pour plusieurs images

                $destination = '../assets/images/products/' . $new_file_name1;
                $resultUploadImg1 = move_uploaded_file($_FILES['productImage1']['tmp_name'], $destination);

                $destination = '../assets/images/products/' . $new_file_name2;
                $resultUploadImg2 = move_uploaded_file($_FILES['productImage2']['tmp_name'], $destination);

                $destination = '../assets/images/products/' . $new_file_name3;
                $resultUploadImg3 = move_uploaded_file($_FILES['productImage3']['tmp_name'], $destination);

                //update du nom de l'image de l'enregistrement d'id
                $query = $db->query("UPDATE products SET images = '$queryContent' WHERE id = $productId");

                return $query;
            }
        }

        return $resultUploadImg;
    }

    //FONCTION QUI VA SUPPRIMER UN PRODUIT EN FONCTION DE SON ID
    function deleteProduct($id)
    {
        $db = dbConnect();

        $threeImages  = explode(',', getProduct($id)['images']);

        //si il a des images, on les supprime avant de le supprimer complement
        if(getProduct($id)['images'] != null){
            unlink('../assets/images/products/' . $threeImages[0]);
            unlink('../assets/images/products/' . $threeImages[1]);
            unlink('../assets/images/products/' . $threeImages[2]);
        }


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

        //suppresion du produit
        $queryDeleteProduct = $db->prepare('DELETE FROM products WHERE id = ?');
        $queryDeleteProduct->execute([
            $id
        ]);

        return $queryDeleteProduct;
    }