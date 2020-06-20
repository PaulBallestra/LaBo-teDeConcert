<!-- Affichage de l'accroche de la page de la commande -->
<section class="mainAccroche">
    <h1 class="pageTitle"> Détail commande n°<?= $order['id_order'] ?> </h1>
</section>

<!-- Affichage de toutes les commandes de l'user -->
<section class="ordersContent">

    <div class="ordersDetails">

        <h2 class="orderInfo"> Commande N°<?= $order['id_order'] ?> du <?= $order['time'] ?> d'un total de <?= $order['price'] ?>€ </h2>

        <h3> Client : <?= $client[1] ?> <?= $client[2] ?> (<?= $client[0] ?>) </h3>

        <?php $details = getDetailsOfOrder($order['id_order']);
        foreach ($details as $detail) : $productDetail = explode("/", $detail['product']); ?>

            <!-- Affichage du contenu de la commande -->
            <div class="orderProductInfo">

                <h3> Produit N°<?= $productDetail[0] ?></h3>
                <h3> Nom : <?= $productDetail[1] ?> </h3>
                <h3> Prix : <?= $productDetail[3] ?>€ </h3>
                <h3> Capacité : <?= $productDetail[2] ?> </h3>
                <h3> Adresse : <?= $productDetail[4] ?> <?= $productDetail[5] ?>, <?= $productDetail[6] ?>, <?= $productDetail[7] ?>, <?= $productDetail[8] ?> </h3>
                <h3> Quantité : <?= $productDetail[9] ?> </h3>

            </div>
        <?php endforeach; ?>

    </div>


</section>