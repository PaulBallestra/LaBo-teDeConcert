<!-- Affichage du titre de la page de modification d'une catégorie -->
<section class="mainAccroche">
    <h1 class="pageTitle"> <?= $category['name'] ?> </h1>
    <h3> Mise à jour </h3>
</section>

<!-- Section qui contiendra le formulaire de maj d'une catégorie -->
<section>

    <!-- Formulaire de mise à jour d'une catégorie -->
    <form action="index.php?page=categories&action=updated" method="post">

        <!-- Section du nom de la catégorie -->
        <section class="sectionInput">
            <label for="categoryName" class="labelName"> Nom </label>
            <input id="categoryName" type="text" name="categoryName" class="inputForm" value="<?= isset($_SESSION['old_inputs']['categoryName']) ? $_SESSION['old_inputs']['categoryName'] : $category['name'] ?>">
        </section>

    </form>

</section>