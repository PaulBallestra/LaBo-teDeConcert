<!-- Affichage de l'accroche de la page des produits -->
<section class="mainAccroche">

    <h1 class="pageTitle"> Produits </h1>

    <section class="sectionProductInput">

        <!-- Barre de recherche de produit pour l'user -->
        <input id="search" type="text" name="search" class="inputForm" placeholder="Recherche">

        <div class="divTrierPar">

            <h3> Trier par : </h3>
            <select name="selectSearchOrderBy" onchange="location = 'index.php?page=products&action=list&by=' + this.options[this.selectedIndex].value;">
                <option value="name" <?= isset($_GET['by']) ? ($_GET['by'] == 'name' ? 'selected' : '') : '' ?>> Nom </option>
                <option value="capacity" <?= isset($_GET['by']) ? ($_GET['by'] == 'capacity' ? 'selected' : '') : '' ?>> Capacité </option>
                <option value="town" <?= isset($_GET['by']) ? ($_GET['by'] == 'town' ? 'selected' : '') : '' ?>> Ville </option>
            </select>

        </div>


    </section>

</section>

<!-- Affichage de la liste des produits -->
<section class="productsContent">

    <!-- Pour chaque catégorie on boucle pour créer sa carte -->
    <?php foreach ($products as $product): ?>

        <?php $productAddress = getAddress($product['id'], false); //récupération de l'adresse
        //Récupération de la premiere image du produit
        $images = explode(',',$product['images']);
        ?>

        <a href="index.php?page=products&action=display&id=<?= $product['id'] ?>">
            <div class="productCard pro-<?= $product['id'] ?>">
                <img class="productImg" src="assets/images/products/<?= $images[0] ?>" alt="<?= 'Miniature ' . $product['name'] ?>">
                <h2 class="productName"> <?= $product['name'] ?> </h2>
                <h2 class="productTownPostalCode"> <?= $productAddress['town'] . ' - ' . $productAddress['postal_code'] ?> </h2>
                <h2 class="productCapacity">  <?= $product['capacity'] ?> <img class="capacitySVG" src="assets/images/pictos/picto-capacity.svg"> <img class="capacitySVGHovered" src="assets/images/pictos/picto-capacity-hovered?svg"> </h2>
            </div>
        </a>

    <?php endforeach; ?>

</section>