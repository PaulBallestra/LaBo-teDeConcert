<!-- Affichage du titre de la page de modification d'une catégorie -->
<section class="mainAccroche">
    <h1 class="pageTitle"> <?= $category['name'] ?> </h1>
    <h3> Mise à jour </h3>
</section>

<!-- Section qui contiendra le formulaire de maj d'une catégorie -->
<section>

    <!-- Formulaire de mise à jour d'une catégorie -->
    <form action="index.php?page=categories&action=updated" method="post">

        <!-- Pour chaque input, si il y a une ancienne valeur, on l'écrit dans la textbox sinon, c'est la valeur actuelle en bd -->

        <!-- Section du nom de la catégorie -->
        <section class="sectionInput">
            <label for="categoryName" class="labelName"> Nom </label>
            <input id="categoryName" type="text" name="categoryName" class="inputForm" value="<?= isset($_SESSION['old_inputs']['categoryName']) ? $_SESSION['old_inputs']['categoryName'] : $category['name'] ?>">
        </section>

        <!-- Section de la description de la catégorie -->
        <section class="sectionInput">
            <label for="categoryDescription" class="labelName"> Description </label>
            <textarea id="categoryDescription" type="text" name="categoryDescription" class="inputFormDescription"><?= isset($_SESSION['old_inputs']['categoryName']) ? $_SESSION['old_inputs']['categoryName'] : $category['description'] ?></textarea>

            <img src="../assets/images/categories/<?= $category['image'] ?>">

        </section>

        <!-- Section de l'image de la catégorie -->


    </form>

</section>