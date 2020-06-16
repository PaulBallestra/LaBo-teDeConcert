<!-- Affichage du titre de la page de gestion des produits -->
<section class="mainAccroche">
    <h1 class="pageTitle"> Gestion Produits </h1>
    <h2> Ajoutez, modifiez et supprimez des produits ! </h2>
</section>

<!-- Affichage de la liste des produits-->
<section class="containerList">

    <!-- Pour chaque produits, on créé une ligne avec un bouton modifier et supprimer -->
    <?php $mod = 0; foreach ($products as $product): ?>

        <!-- Style d'une ligne qui sera répétée pour chaque produits, le mod permet de changer la couleur du background pour simplifier la lecture -->
        <div class="listContentLine <?= $mod%2 == 0 ? ' listContentBright' : ''?>">
            <!-- Nom du produit -->
            <h4 class="lineName"> <?= $product['name'] ?> </h4>

            <!-- Style des boutons modifier et supprimer -->
            <div class="lineButtons">
                <a href="index.php?page=categories&action=update&id=<?= $product['id'] ?>"> Modifier </a>
                <a href="index.php?page=categories&action=delete&id=<?= $product['id'] ?>"> Supprimer </a>
            </div>
        </div>

        <?php $mod++; ?>

    <?php endforeach; ?>

</section>