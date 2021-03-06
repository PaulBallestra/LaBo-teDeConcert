<!-- Affichage de l'accroche de la page des catégories -->
<section class="mainAccroche">
    <h1 class="pageTitle"> <?= $category['name'] ?> </h1>
    <h3> <?= $category['description'] ?> </h3>
</section>

<!-- Affichage de tous les produits en rapport avec la catégorie selectionnée -->
<section class="productsContent">

    <!-- Pour chaque catégorie on boucle pour créer sa carte -->
    <?php if(!empty($productsInCategory)): //on check si la catégorie n'est pas vide

        foreach ($productsInCategory as $product): ?>

            <?php $productAddress = getAddress($product['id'], false); $images = explode(',',$product['images']); ?> <!-- On chope son adresse pour l'afficher ensuite, et les images -->

            <a href="index.php?page=products&action=display&id=<?= $product['id'] ?>">
                <div class="productCard pro-<?= $product['id'] ?>">
                    <img class="productImg" src="assets/images/products/<?= $images[0] ?>" alt="<?= 'Miniature ' . $product['name'] ?>">
                    <h2 class="productName"> <?= $product['name'] ?> </h2>
                    <h2 class="productTownPostalCode"> <?= $productAddress['town'] . ' - ' . $productAddress['postal_code'] ?> </h2>
                    <h2 class="productCapacity">  <?= $product['capacity'] ?> <img class="capacitySVG" src="assets/images/pictos/picto-capacity.svg"> <img class="capacitySVGHovered" src="assets/images/pictos/picto-capacity-hovered?svg"> </h2>
                </div>
            </a>

        <?php endforeach; ?>

    <?php else: //sinon on indique a l"user que la catégorie est vide?>

        <section style="margin: 10% auto;">

            <h1 style="color: white;"> Cette catégorie est vide. </h1>

        </section>

    <?php endif; ?>

</section>