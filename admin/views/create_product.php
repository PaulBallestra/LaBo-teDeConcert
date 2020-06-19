<!-- Affichage du titre de la page de création d'un produit -->
<section class="mainAccroche">
    <h1 class="pageTitle"> Produit </h1>
    <h3> Création </h3>
</section>

<!-- Section qui contiendra le formulaire de création d'un produit -->
<section>

    <!-- Formulaire de mise à jour d'une catégorie -->
    <form action="index.php?page=products&action=add" method="post" enctype="multipart/form-data">

        <!-- Section du nom du produit -->
        <section class="sectionInput">
            <label for="productName" class="labelName"> Nom *</label>
            <input id="productName" type="text" name="productName" class="inputForm" value="<?= isset($_SESSION['old_inputs']) ? $_SESSION['old_inputs']['productName'] : '' ?>" required>
        </section>

        <!-- Section de la description du produit -->
        <section class="sectionInput">
            <label for="productDescription" class="labelName"> Description *</label>
            <textarea id="productDescription" type="text" name="productDescription" class="inputFormDescription" required><?= isset($_SESSION['old_inputs']) ? $_SESSION['old_inputs']['productDescription'] : '' ?></textarea>
        </section>

        <!-- Section double qui contiendra 2 inputs (price et capacity) -->
        <section class="doubleSectionInput">

            <!-- Section de la capacité du produit -->
            <section class="sectionInput">
                <label for="productCapacity" class="labelName"> Capacité *</label>
                <input id="productCapacity" type="number" name="productCapacity" class="inputFormDouble" value="<?= isset($_SESSION['old_inputs']) ? $_SESSION['old_inputs']['productCapacity'] : '' ?>" required>
            </section>

            <!-- Section du prix du produit -->
            <section class="sectionInput">
                <label for="productPrice" class="labelName"> Prix *</label>
                <input id="productPrice" type="number" name="productPrice" class="inputFormDouble" value="<?= isset($_SESSION['old_inputs']) ? $_SESSION['old_inputs']['productPrice'] : '' ?>" required>
            </section>

        </section>

        <section class="mainAccroche" style="margin: 30px 0px 0px 0px">
            <h2> Images du produit </h2>
        </section>

        <section class="sectionImages">

            <!-- Section des images du produit -->
            <div class="sectionInput inputImage">
                <label for="productImage1" class="labelName"> Image 1 * </label>
                <input type="file" name="productImage1" id="productImage1" accept=".gif, .png, .jpg, .jpeg" required>
            </div>

            <!-- Section des images du produit -->
            <div class="sectionInput inputImage">
                <label for="productImage2" class="labelName"> Image 2 * </label>
                <input type="file" name="productImage2" id="productImage2" accept=".gif, .png, .jpg, .jpeg" required>
            </div>

            <!-- Section des images du produit -->
            <div class="sectionInput inputImage">
                <label for="productImage3" class="labelName"> Image 3 * </label>
                <input type="file" name="productImage3" id="productImage3" accept=".gif, .png, .jpg, .jpeg" required>
            </div>

        </section>

        <!-- Section du choix de la/les catégories du produit -->
        <section class="sectionInput">
            <label for="categoriesId" class="labelName"> Catégories *</label>
            <select name="categoriesId[]" id="categoriesId" multiple required>

                <?php foreach ($categories as $category) : ?>

                    <option value=<?= $category['id'] ?>>
                        <?= $category['name'] ?>
                    </option> <!-- value est la valeur retournée en post -->

                <?php endforeach; ?>

            </select>
        </section>


        <section class="mainAccroche" style="margin: 30px 0px 0px 0px">
            <h2> Adresse du produit </h2>
        </section>

        <!-- ADRESSE DU PRODUIT -->
        <!-- Section du numéro de l'adresse du produit -->
        <section class="sectionInput">
            <label for="productAddressNumber" class="labelName"> Numéro *</label>
            <input id="productAddressNumber" type="number" name="productAddressNumber" class="inputForm" value="<?= isset($_SESSION['old_inputs']) ? $_SESSION['old_inputs']['productAddressNumber'] : '' ?>" required>
        </section>

        <!-- Section de la rue du produit -->
        <section class="sectionInput">
            <label for="productAddressStreet" class="labelName"> Rue *</label>
            <input id="productAddressStreet" type="text" name="productAddressStreet" class="inputForm" value="<?= isset($_SESSION['old_inputs']) ? $_SESSION['old_inputs']['productAddressStreet'] : '' ?>" required>
        </section>

        <!-- Section double qui contiendra 2 inputs (ville et code postal) -->
        <section class="doubleSectionInput">

            <!-- Section de la ville du produit -->
            <section class="sectionInput">
                <label for="productAddressTown" class="labelName"> Ville *</label>
                <input id="productAddressTown" type="text" name="productAddressTown" class="inputFormDouble" value="<?= isset($_SESSION['old_inputs']) ? $_SESSION['old_inputs']['productAddressTown'] : '' ?>" required>
            </section>

            <!-- Section de la ville du produit -->
            <section class="sectionInput">
                <label for="productAddressPostalCode" class="labelName"> Code Postal *</label>
                <input id="productAddressPostalCode" type="number" name="productAddressPostalCode" class="inputFormDouble" value="<?= isset($_SESSION['old_inputs']) ? $_SESSION['old_inputs']['productAddressPostalCode'] : '' ?>" required>
            </section>

        </section>

        <!-- Section du pays du produit -->
        <section class="sectionInput">
            <label for="productAddressCountry" class="labelName"> Pays *</label>
            <input id="productAddressCountry" type="text" name="productAddressCountry" class="inputForm" value="<?= isset($_SESSION['old_inputs']) ? $_SESSION['old_inputs']['productAddressCountry'] : '' ?>" required>
        </section>

        <p> * : Champs obligatoires. </p>

        <!-- Section du boutton valider -->
        <section class="sectionButtonCreate">
            <button type="submit" class="btnSubmit"> Valider </button>
        </section>

    </form>

</section>