<!-- Affichage de l'accroche de la page des produits -->
<section class="mainAccroche">

    <h1 class="pageTitle"> Produits </h1>

    <section class="sectionProductInput">

        <!-- Barre de recherche de produit pour l'user -->
        <input id="search" type="text" name="search" class="inputForm" placeholder="Recherche">

        <div class="divTrierPar">

            <h3> Trier par : </h3>
            <select name="selectSearchOrderBy" onchange="location = 'index.php?page=products&action=list&orderBy=' + this.options[this.selectedIndex].value;">
                <option value="name" <?= isset($_GET['orderBy']) ? ($_GET['orderBy'] == 'name' ? 'selected' : '') : '' ?>> Nom </option>
                <option value="capacity" <?= isset($_GET['orderBy']) ? ($_GET['orderBy'] == 'capacity' ? 'selected' : '') : '' ?>> Capacité </option>
                <option value="town" <?= isset($_GET['orderBy']) ? ($_GET['orderBy'] == 'town' ? 'selected' : '') : '' ?>> Ville </option>
            </select>

        </div>


    </section>

</section>

<!-- Affichage de la liste des produits -->
<section class="productsContent">
    
    <!-- Pour chaque catégorie on boucle pour créer sa carte -->
    <?php foreach ($products as $product): ?>

        <?php $productAddress = getAddress($product['id'], false) ?>

        <a href="index.php?page=products&action=display&id=<?= $product['id'] ?>">
            <div class="productCard pro-<?= $product['id'] ?>">
                <img class="productImg" src="assets/images/products/<?= $product['images'] ?>" alt="<?= 'Miniature ' . $product['name'] ?>">
                <h2 class="productName"> <?= $product['name'] ?> </h2>
                <h2 class="productTownPostalCode"> <?= $productAddress['town'] . ' - ' . $productAddress['postal_code'] ?> </h2>
                <h2 class="productCapacity">  <?= $product['capacity'] ?> <img src="assets/images/pictos/picto-capacity.svg"> </h2>
            </div>
        </a>

    <?php endforeach; ?>

</section>