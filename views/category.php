<!-- Affichage de l'accroche de la page des catégories -->
<section class="mainAccroche">
    <h1 class="pageTitle"> Catégories </h1>
    <h3> Sur l'eau ou sur terre vous avez le choix ! </h3>
</section>

<!-- Affichage de la liste des catégories -->
<section class="categoriesContent">

    <!-- Pour chaque catégorie on boucle pour créer sa carte -->
    <?php foreach ($categories as $category): ?>

        <a href="index.php?page=caterogies&action=display&id=<?= $category['id'] ?>">
            <div class="categoryCard cat-<?= $category['id'] ?>">
                <img class="categoryImg" src="assets/images/backgroundLA.jpg">
                <h2 class="categoryName"> <?= $category['name'] ?> </h2>
            </div>
        </a>

    <?php endforeach; ?>

</section>