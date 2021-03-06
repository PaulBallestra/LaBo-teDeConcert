<!-- Affichage du titre de la page de gestion des users -->
<section class="mainAccroche">
    <h1 class="pageTitle"> Gestion Utilisateurs </h1>
    <h3> Ajoutez, modifiez et supprimez des utilisateurs ! </h3>
</section>

<!-- Affichage de la liste des users-->
<section class="containerList">

    <!-- Affichage de la ligne de création d'un nouvel user -->
    <div class="listContentLine listContentAdd">

        <h4 class="lineName"> Nouvel Utilisateur ? </h4>
        <div class="lineButtons">
            <a href="index.php?page=users&action=new"> Ajouter </a>
        </div>

    </div>

    <?php if(!empty($users)) : ?>

        <!-- Pour chaque utilisateurs, on créé une ligne avec un bouton modifier et supprimer -->
        <?php $mod = 0; foreach ($users as $user): ?>

            <!-- Style d'une ligne qui sera répétée pour chaque users, le mod permet de changer la couleur du background pour simplifier la lecture -->
            <div class="listContentLine <?= $mod%2 == 0 ? ' listContentBright' : ''?>">
                <div class="lineInfos">
                    <!-- Id de l'user -->
                    <h3 class="lineName"> <?= $user['id'] ?> </h3>
                    <!-- Nom/prenom de l'user -->
                    <h4 class="lineName"> <?= $user['firstname'] ?> <?= $user['lastname'] ?> </h4>
                </div>

                <!-- Style des boutons modifier et supprimer -->
                <div class="lineButtons">
                    <a href="index.php?page=users&action=update&id=<?= $user['id'] ?>"> Modifier </a>
                    <a href="index.php?page=users&action=delete&id=<?= $user['id'] ?>"> Supprimer </a>
                </div>
            </div>

            <?php $mod++; ?>

        <?php endforeach; ?>

    <?php else: //sinon on indique a l"admin qu'il n'y a aucun users?>

    <section style="margin: 10% auto;">

        <h1 style="color: white;"> Aucune utilisateurs. </h1>

    </section>

    <?php endif; ?>

</section>