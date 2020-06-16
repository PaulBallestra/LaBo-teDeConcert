<!-- Affichage du titre de la page des catégories -->
<section class="mainAccroche">
    <h1 class="pageTitle"> Gestion Catégories </h1>
    <h3> Ajoutez, modifiez et supprimez des catégories ! </h3>
</section>

<!-- Affichage de la liste des catégories-->
<section class="containerList">

    <!-- Affichage de la ligne de création d'une nouvelle catégorie -->
    <div class="listContentLine listContentAdd">

        <h4 class="lineName"> Nouvelle Catégorie ? </h4>
        <div class="lineButtons">
            <a href="index.php?page=categories&action=new"> Ajouter </a>
        </div>

    </div>

    <!-- Pour chaque catégories, on créé une ligne avec un bouton modifier et supprimer -->
    <?php $mod = 0; foreach ($categories as $category): ?>

        <!-- Style d'une ligne qui sera répétée pour chaque catégorie, le mod permet de changer la couleur du background pour simplifier la lecture -->
        <div class="listContentLine <?= $mod%2 == 0 ? ' listContentBright' : ''?>">
            <!-- Nom de la catégorie -->
            <h4 class="lineName"> <?= $category['name'] ?> </h4>

            <!-- Style des boutons modifier et supprimer -->
            <div class="lineButtons">
                <a href="index.php?page=categories&action=update&id=<?= $category['id'] ?>"> Modifier </a>
                <a href="index.php?page=categories&action=delete&id=<?= $category['id'] ?>"> Supprimer </a>
            </div>
        </div>

        <?php $mod++; ?>

    <?php endforeach; ?>

</section>