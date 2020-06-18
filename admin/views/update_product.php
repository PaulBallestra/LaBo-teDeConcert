<!-- Affichage du titre de la page de création d'un produit -->
<section class="mainAccroche">
    <h1 class="pageTitle"> <?= $product['name'] ?> </h1>
    <h3> Mise à jour </h3>
</section>

<!-- Section qui contiendra le formulaire de création d'un produit -->
<section>

    <!-- Formulaire de mise à jour d'une catégorie -->
    <form action="index.php?page=products&action=updated&id=<?= $product['id'] ?>" method="post" enctype="multipart/form-data">

        <!-- Section du nom du produit -->
        <section class="sectionInput">
            <label for="productName" class="labelName"> Nom </label>
            <input id="productName" type="text" name="productName" class="inputForm" value="<?= isset($_SESSION['old_inputs']) ? $_SESSION['old_inputs']['productName'] : $product['name'] ?>" required>
        </section>

        <!-- Section de la description du produit -->
        <section class="sectionInput">
            <label for="productDescription" class="labelName"> Description </label>
            <textarea id="productDescription" type="text" name="productDescription" class="inputFormDescription" required><?= isset($_SESSION['old_inputs']) ? $_SESSION['old_inputs']['productDescription'] : $product['description'] ?></textarea>
        </section>

        <!-- Section double qui contiendra 2 inputs (price et capacity) -->
        <section class="doubleSectionInput">

            <!-- Section de la capacité du produit -->
            <section class="sectionInput">
                <label for="productCapacity" class="labelName"> Capacité </label>
                <input id="productCapacity" type="number" name="productCapacity" class="inputFormDouble" value="<?= isset($_SESSION['old_inputs']) ? $_SESSION['old_inputs']['productCapacity'] : $product['capacity'] ?>" required>
            </section>

            <!-- Section du prix du produit -->
            <section class="sectionInput">
                <label for="productPrice" class="labelName"> Prix </label>
                <input id="productPrice" type="number" name="productPrice" class="inputFormDouble" value="<?= isset($_SESSION['old_inputs']) ? $_SESSION['old_inputs']['productPrice'] : $product['price'] ?>" required>
            </section>

        </section>

        <!-- Section des images du produit -->
        <section class="sectionInput inputImage">
            <label for="productImages" class="labelName"> Image : </label>
            <input type="file" name="productImages" id="productImages" accept="image/gif, image/png, image/jpg, image/jpeg" multiple required>
        </section>

        <!-- Section du choix de la/les catégories du produit -->
        <section class="sectionInput">
            <label for="categoriesId" class="labelName"> Catégories </label>
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
            <label for="productAddressNumber" class="labelName"> Numéro </label>
            <input id="productAddressNumber" type="number" name="productAddressNumber" class="inputForm" value="<?= isset($_SESSION['old_inputs']) ? $_SESSION['old_inputs']['productAddressNumber'] : $productAddress['number'] ?>" required>
        </section>

        <!-- Section de la rue du produit -->
        <section class="sectionInput">
            <label for="productAddressStreet" class="labelName"> Rue </label>
            <input id="productAddressStreet" type="text" name="productAddressStreet" class="inputForm" value="<?= isset($_SESSION['old_inputs']) ? $_SESSION['old_inputs']['productAddressStreet'] : $productAddress['street'] ?>" required>
        </section>

        <!-- Section double qui contiendra 2 inputs (ville et code postal) -->
        <section class="doubleSectionInput">

            <!-- Section de la ville du produit -->
            <section class="sectionInput">
                <label for="productAddressTown" class="labelName"> Ville </label>
                <input id="productAddressTown" type="text" name="productAddressTown" class="inputFormDouble" value="<?= isset($_SESSION['old_inputs']) ? $_SESSION['old_inputs']['productAddressTown'] : $productAddress['town'] ?>" required>
            </section>

            <!-- Section de la ville du produit -->
            <section class="sectionInput">
                <label for="productAddressPostalCode" class="labelName"> Code Postal </label>
                <input id="productAddressPostalCode" type="number" name="productAddressPostalCode" class="inputFormDouble" value="<?= isset($_SESSION['old_inputs']) ? $_SESSION['old_inputs']['productAddressPostalCode'] : $productAddress['postal_code'] ?>" required>
            </section>

        </section>

        <!-- Section du pays du produit -->
        <section class="sectionInput">
            <label for="productAddressCountry" class="labelName"> Pays </label>
            <input id="productAddressCountry" type="text" name="productAddressCountry" class="inputForm" value="<?= isset($_SESSION['old_inputs']) ? $_SESSION['old_inputs']['productAddressCountry'] : $productAddress['country'] ?>" required>
        </section>



        <!-- Section du boutton valider -->
        <section class="sectionButtonCreate">
            <button type="submit" class="btnSubmit"> Valider </button>
        </section>

    </form>

</section>