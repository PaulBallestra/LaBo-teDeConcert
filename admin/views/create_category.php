<!-- Affichage du titre de la page de création d'une catégorie -->
<section class="mainAccroche">
    <h1 class="pageTitle"> Catégorie </h1>
    <h3> Création </h3>
</section>

<!-- Section qui contiendra le formulaire de création d'une catégorie -->
<section>

    <!-- Formulaire de mise à jour d'une catégorie -->
    <form action="index.php?page=categories&action=add" method="post" enctype="multipart/form-data">

        <!-- Section du nom de la catégorie -->
        <section class="sectionInput">
            <label for="categoryName" class="labelName"> Nom * </label>
            <input id="categoryName" type="text" name="categoryName" class="inputForm" required>
        </section>

        <!-- Section de la description de la catégorie -->
        <section class="sectionInput">
            <label for="categoryDescription" class="labelName"> Description * </label>
            <textarea id="categoryDescription" type="text" name="categoryDescription" class="inputFormDescription" required></textarea>
        </section>

        <!-- Section de l'image de la catégorie -->
        <section class="sectionInput inputImage">
            <label for="categoryImage" class="labelName"> Image * </label>
            <input type="file" name="categoryImage" id="categoryImage" accept=".gif, .png, .jpg, .jpeg" required>
        </section>

        <p> * : Champs obligatoires. </p>

        <!-- Section du boutton valider -->
        <section class="sectionButtonCreate">
            <button type="submit" class="btnSubmit"> Valider </button>
        </section>

    </form>

</section>