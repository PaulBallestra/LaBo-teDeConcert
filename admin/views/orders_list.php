<!-- Affichage du titre de la page de gestion des produits -->
<section class="mainAccroche">
    <h1 class="pageTitle"> Gestion Commandes </h1>
    <h3> Historique des commandes </h3>
</section>

<!-- Affichage de la liste des produits-->
<section class="containerList">

    <?php if(!empty($orders)) : ?>
        <!-- Pour chaque commande, on créé une ligne avec un bouton Détails -->
        <?php $mod = 0; foreach ($orders as $order): ?>

            <!-- Style d'une ligne qui sera répétée pour chaque produits, le mod permet de changer la couleur du background pour simplifier la lecture -->
            <div class="listContentLine <?= $mod%2 == 0 ? ' listContentBright' : ''?>">
                <div class="lineInfos">
                    <!-- Id de la commande -->
                    <h3 class="lineName"> <?= $order['id'] ?> </h3>
                    <!-- Id de l'user -->
                    <h3 class="lineName"> <?= $order['id_user'] ?> </h3>
                    <!-- Date de la commande -->
                    <h4 class="lineName"> <?= $order['time'] ?> </h4>
                </div>

                <!-- Style des boutons détail de la commande -->
                <div class="lineButtons">
                    <a href="index.php?page=orders&action=display&id=<?= $order['id'] ?>"> Détails </a>
                </div>
            </div>

            <?php $mod++; ?>

        <?php endforeach; ?>

    <?php else: //sinon on indique a l"admin qu'il n'y a aucune commandes?>

    <section style="margin: 10% auto;">

        <h1 style="color: white;"> Aucune commandes. </h1>

    </section>

    <?php endif; ?>

</section>