<!-- Affichage de l'accroche de la page des catégories -->
<section class="mainAccroche">
    <h1 class="pageTitle"> <?= $category['name'] ?> </h1>
    <h3> <?= $category['description'] ?> </h3>
</section>

<!-- Affichage de tous les produits en rapport avec la catégorie selectionnée -->
<section class="productsContent">

    <!-- Pour chaque catégorie on boucle pour créer sa carte -->
    <?php foreach ($productsInCategory as $product): ?>

        <?php $productAddress = getAddress($product['id'], false) ?> <!-- On chope son adresse pour l'afficher ensuite -->

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