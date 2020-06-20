<?php

    //FONCTION QUI VA RETOURNER UN PRODUIT UNIQUE EN FONCTION DE SON ID
    function getProduct($id)
    {
        $db = dbConnect();

        $queryGetProduct = $db->prepare('SELECT * FROM products WHERE id = ?');
        $queryGetProduct->execute([
            $id //id du produit selectionné
        ]);

        return $queryGetProduct->fetch();

    }

    //FONCTION QUI RETOURNE TOUS LES PRODUITS DISPONIBLES
    function getProducts()
    {
        $db = dbConnect();

        $selectedProducts = $db->query('SELECT * FROM products WHERE quantity >= 1 ORDER BY name')->fetchAll(); //On récupère tous les produits depuis la bd que l'on stocke dans selectedProducts

        return $selectedProducts; //On retourne le tableau de tous les produits
    }

    //FONCTION QUI RETOURNE TOUS LES PRODUIT PAR CAPACITE
    function getProductsByCapacity()
    {
        $db = dbConnect();

        $selectedProducts = $db->query('SELECT * FROM products WHERE quantity >= 1 ORDER BY capacity DESC')->fetchAll();

        return $selectedProducts;
    }

    //FONCTION QUI RETOURNE TOUS LES PRODUITS PAR VILLE
    function getProductsByTown()
    {
        $db = dbConnect();

        $selectedProducts = $db->query('
            SELECT A.town, P.*
            FROM addresses A, products P
            WHERE A.id_product = P.id
            AND P.quantity >= 1
            ORDER BY A.town
        ')->fetchAll();

        return $selectedProducts;
    }

    //FONCTION QUI VA RENVOYER TOUS LES PRODUITS QUI CORRESPONDENT A LA RECHERCHE
    function getProductsBySearch($informations)
    {
        $db = dbConnect();

        $safe_value = htmlspecialchars($informations);

        //§requete qui va chercher tous ce qui a un rapport avec la recherche
        $queryGetProducts = $db->query("
            SELECT DISTINCT P.* 
            FROM products P
            INNER JOIN addresses A ON A.id_product = P.id
            INNER JOIN product_categories PC ON PC.id_product = P.id
            INNER JOIN categories C ON C.id = PC.id_category
            WHERE P.name LIKE '%".$safe_value."%' OR P.description LIKE '%".$safe_value."%' OR P.capacity LIKE '%".$safe_value."%' OR P.price LIKE '%".$safe_value."%'
            OR A.number LIKE '%".$safe_value."%' OR A.street LIKE '%".$safe_value."%' OR A.town LIKE '%".$safe_value."%' OR A.postal_code LIKE '%".$safe_value."%' OR A.country LIKE '%".$safe_value."%'
            OR C.name LIKE '%".$safe_value."%' OR C.description LIKE '%".$safe_value."%'
            AND P.quantity >= 1")->fetchAll();

        return $queryGetProducts;
    }

    //FONCTION QUI VA RENVOYER TOUS LES PRODUTIS QUI CORRESPONDENT A LA RECHERCHE DE L'USER
    function getProductsByIndexSearch($informations)
    {
        $db = dbConnect();

        $safe_value = htmlspecialchars($informations['searchTown']);

        $capacityValue = array(1, 2, 3, 4);


        //en fonction de la selected value
        switch($informations['searchCapacity']){
            case 1:
                $queryMin = 100;
                $queryMax = 2500;
                break;

            case 2:
                $queryMin = 2500;
                $queryMax = 5000;
                break;

            case 3:
                $queryMin = 5000;
                $queryMax = 10000;
                break;

            case 4:
                $queryMin = 10000;
                $queryMax = 100000;
                break;
        }

        $queryGetProducts = $db->query("
            SELECT DISTINCT P.*
            FROM products P
            INNER JOIN product_categories PC ON PC.id_product = P.id
            INNER JOIN addresses A ON A.id_product = P.id
            WHERE PC.id_category = '".$informations['searchCategory']."'
            AND P.name LIKE '%".$safe_value."%'
            OR P.description LIKE '%".$safe_value."%'
            OR A.town LIKE '%".$safe_value."%'
            AND P.capacity BETWEEN '".$queryMin."' AND '".$queryMax."'
            AND P.quantity >= 1
        ")->fetchAll();

        return $queryGetProducts;
    }

    //FONCTION QUI RETOURNE TOUS LES PRODUITS EN FONCTION DE LA CATEGORIE SELECTIONNÉE
    function getProductsByCategory($idCategory)
    {
        $db = dbConnect();

        /* Jointure qui chopera tous les produits inclus dans une catégories précise */
        $queryGetProductsByCategory = $db->prepare("
            SELECT P.*
            FROM categories C
            INNER JOIN product_categories PC ON C.id = PC.id_category
            INNER JOIN products P ON PC.id_product = P.id
            WHERE c.id = ?
            AND P.quantity >= 1            
        ");

        $queryGetProductsByCategory->execute([
            $idCategory
        ]);

        $resultGetProductsByCategory = $queryGetProductsByCategory->fetchAll();

        return $resultGetProductsByCategory;

    }

    //FONCTION QUI RETOURNE VRAI SI UN PRODUIT EXISTE EN FONCTION DE SON ID
    function checkProductExists($id)
    {
        $db = dbConnect();

        $queryCheckProduct = $db->prepare('SELECT id FROM products WHERE id = ?');
        $queryCheckProduct->execute([
            $id
        ]);

        return $queryCheckProduct->fetch();
    }

    //FONCTION QUI VA AJOUTER UN PRODUIT SPECIFIQUE DANS UN PANIER SPECIFIQUE
    function addProductInCart($idProduct, $idCart)
    {
        $db = dbConnect();

        $queryAddProduct = $db->prepare('INSERT INTO products_cart (id_product, id_cart) VALUES (?, ?)');
        $queryAddProduct->execute([
            $idProduct,
            $idCart
        ]);

        return $queryAddProduct;
    }

    //FONCTION QUI VA VERIFIER QU'UN PRODUIT N'EST PAS DEJA DANS LE PANIER DE L'USER
    function checkProductInCart($idProduct, $idCart)
    {
        $db = dbConnect();

        $queryCheckProductInCart = $db->prepare('SELECT * FROM products_cart WHERE id_cart = ? AND id_product = ?');
        $queryCheckProductInCart->execute([
            $idCart,
            $idProduct
        ]);

        $resultQuery = $queryCheckProductInCart->fetch();

        return $resultQuery;
    }

    //FUNCTION QUI VA RETOURNER TOUS LES PRODUITS D'UN PANIER SPECIFIQUE
    function getProductsInCart($idCart)
    {
        $db = dbConnect();

        $queryGetProducts = $db->prepare('
            SELECT P.*
            FROM products P
            INNER JOIN products_cart PC ON PC.id_product = P.id
            WHERE PC.id_cart = ?');

        $queryGetProducts->execute([
            $idCart
        ]);

        return $queryGetProducts->fetchAll();
    }

    //FONCTION QUI VA SUPPRIMER UN PRODUIT SPECIFIQUE D'UN PANIER SPECIFIQUE
    function deleteProductInCart($idCart, $idProduct)
    {
        $db = dbConnect();

        $queryDeleteProduct = $db->prepare('
            DELETE
            FROM products_cart
            WHERE id_cart = ?
            AND id_product = ?
        ');

        $queryDeleteProduct->execute([
            $idCart,
            $idProduct
        ]);

        return $queryDeleteProduct;
    }

    //FONCTION QUI VA SUPPRIMER TOUS LES PRODUITS LIES A UN PANIER
    function deleteProductsInCart($idCart)
    {
        $db = dbConnect();

        $queryDeleteProducts = $db->prepare('
            DELETE PC.*
            FROM products_cart PC
            INNER JOIN carts C ON C.id = PC.id_cart
            WHERE C.id = ?
        ');

        $queryDeleteProducts->execute([
            $idCart
        ]);

        return $queryDeleteProducts;
    }

    //FONCTION QUI VA UPDATE LA QUANTITE D'UN PRODUIT EN FONCTION DE LA QUANTITE ACHETEE
    function orderedProduct($id, $quantity)
    {
        $db = dbConnect();

        $calculNewQuantity = getProduct($id)['quantity']-$quantity;

        $querySetQuantityProduct = $db->prepare('UPDATE products SET quantity = ? WHERE id = ?');
        $querySetQuantityProduct->execute([
            $calculNewQuantity,
            $id
        ]);

        return $querySetQuantityProduct;
    }