<!-- Affichage du titre de la page de gestion des produits -->
<section class="mainAccroche">
    <h1 class="pageTitle"> Gestion Produits </h1>
    <h3> Ajoutez, modifiez et supprimez des produits ! </h3>
</section>

<!-- Affichage de la liste des produits-->
<section class="containerList">

    <!-- Affichage de la ligne de création d'un nouveau produit -->
    <div class="listContentLine listContentAdd">

        <h4 class="lineName"> Nouveau Produit ? </h4>
        <div class="lineButtons">
            <a href="index.php?page=products&action=new"> Ajouter </a>
        </div>

    </div>

    <?php if(!empty($products)) : ?>

        <!-- Pour chaque produits, on créé une ligne avec un bouton modifier et supprimer -->
        <?php $mod = 0; foreach ($products as $product): ?>

            <!-- Style d'une ligne qui sera répétée pour chaque produits, le mod permet de changer la couleur du background pour simplifier la lecture -->
            <div class="listContentLine <?= $mod%2 == 0 ? ' listContentBright' : ''?>">
                <div class="lineInfos">
                    <!-- Id du produit -->
                    <h3 class="lineName"> <?= $product['id'] ?> </h3>
                    <!-- Nom du produit -->
                    <h4 class="lineName"> <?= $product['name'] ?> </h4>
                </div>

                <!-- Style des boutons modifier et supprimer -->
                <div class="lineButtons">
                    <a href="index.php?page=products&action=update&id=<?= $product['id'] ?>"> Modifier </a>
                    <a href="index.php?page=products&action=delete&id=<?= $product['id'] ?>"> Supprimer </a>
                </div>
            </div>

            <?php $mod++; ?>

        <?php endforeach; ?>

    <?php else: //sinon on indique a l"admin qu'il n'y a aucun produits?>

    <section style="margin: 10% auto;">

        <h1 style="color: white;"> Aucun produits. </h1>

    </section>

    <?php endif; ?>

</section>