<!-- Affichage de l'accroche de la page des catégories -->
<section class="mainAccroche">
    <h1 class="pageTitle"> Vos commandes </h1>
</section>

<!-- Affichage de toutes les commandes de l'user -->
<section class="ordersContent">

    <!-- Pour chaque catégorie on boucle pour créer sa carte -->
    <?php if(!empty($orders)): //on check si il a déjà des orders

        foreach ($orders as $order): //Pour chaque commande, on affiche les details ?>

            <div class="ordersDetails">

                <h2 class="orderInfo"> Commande N°<?= $order['id'] ?> du <?= $order['time'] ?> d'un total de <?= $order['price'] ?>€ </h2>

                <?php $details = getDetailsOfOrder($order['id']);
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

        <?php endforeach; ?>

    <?php else: //sinon on indique a l"user qu'il n'y a aucune commandes ?>

        <section style="margin: 10% auto;">

            <h1 style="color: white;"> Vous n'avez aucunes commandes. </h1>

        </section>

    <?php endif; ?>

</section>