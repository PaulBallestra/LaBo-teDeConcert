<!-- Affichage du titre de la page de modification d'une catégorie -->
<section class="mainAccroche">
    <h1 class="pageTitle"> <?= $category['name'] ?> </h1>
    <h3> Mise à jour </h3>
</section>

<!-- Section qui contiendra le formulaire de maj d'une catégorie -->
<section>

    <!-- Formulaire de mise à jour d'une catégorie -->
    <form action="index.php?page=categories&action=updated&id=<?= $category['id'] ?>" method="post">

        <!-- Pour chaque input, si il y a une ancienne valeur, on l'écrit dans la textbox sinon, c'est la valeur actuelle en bd -->

        <!-- Section du nom de la catégorie -->
        <section class="sectionInput">
            <label for="categoryName" class="labelName"> Nom </label>
            <input id="categoryName" type="text" name="categoryName" class="inputForm" value="<?= isset($_SESSION['old_inputs']['categoryName']) ? $_SESSION['old_inputs']['categoryName'] : $category['name'] ?>" required>
        </section>

        <!-- Section de la description de la catégorie -->
        <section class="sectionInput">
            <label for="categoryDescription" class="labelName"> Description </label>
            <textarea id="categoryDescription" type="text" name="categoryDescription" class="inputFormDescription" required><?= isset($_SESSION['old_inputs']['categoryDescription']) ? $_SESSION['old_inputs']['categoryDescription'] : $category['description'] ?></textarea>
        </section>

        <!-- Section de l'image de la catégorie -->
        <section class="sectionInput inputImage">
            <label for="categoryImage" class="labelName"> Image : </label>
            <input type="file" name="categoryImage" id="categoryImage" accept="image/gif, image/png, image/jpg, image/jpeg" value="../assets/images/categories/<?= $category['image'] ?>" required>
            <img style="max-width: 30vw; max-height: 20vh; border: 2px solid white;" src="../assets/images/categories/<?= $category['image'] ?>"> <!-- Miniature de l'image de la catégorie -->
        </section>

        <!-- Section du bouton update -->
        <section class="sectionButtonCreate">
            <button type="submit" class="btnSubmit"> Mettre à jour </button>
        </section>

    </form>

</section>