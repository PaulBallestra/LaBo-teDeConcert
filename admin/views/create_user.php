<!-- Affichage du titre de la page de création d'un user -->
<section class="mainAccroche">
    <h1 class="pageTitle"> Utilisateur </h1>
    <h3> Création </h3>
</section>

<!-- Section du formulaire de création -->
<section>

    <!-- Formulaire de mise à jour d'une catégorie -->
    <form action="index.php?page=users&action=add" method="post">

        <!-- Section du nom de l'user -->
        <section class="sectionInput">
            <label for="userLastname" class="labelName"> Nom *</label>
            <input id="userLastname" type="text" name="userLastname" class="inputForm" value="<?= isset($_SESSION['old_inputs']) ? $_SESSION['old_inputs']['userLastname'] : '' ?>" required>
        </section>

        <!-- Section du prénom de l'user -->
        <section class="sectionInput">
            <label for="userFirstname" class="labelName"> Prénom *</label>
            <input id="userFirstname" type="text" name="userFirstname" class="inputForm" value="<?= isset($_SESSION['old_inputs']) ? $_SESSION['old_inputs']['userFirstname'] : '' ?>" required>
        </section>

        <!-- Section de l'email de l'user -->
        <section class="sectionInput">
            <label for="userEmail" class="labelName"> Email *</label>
            <input id="userEmail" type="text" name="userEmail" class="inputForm" value="<?= isset($_SESSION['old_inputs']) ? $_SESSION['old_inputs']['userEmail'] : '' ?>" required>
        </section>

        <!-- Section du password de l'user -->
        <section class="sectionInput">
            <label for="userPassword" class="labelName"> Mot de passe *</label>
            <input id="userPassword" type="password" name="userPassword" class="inputForm" value="" required>
        </section>


        <!-- Section du numéro de téléphone d'un user (pas obligatoire) -->
        <section class="sectionInput">
            <label for="userPhone" class="labelName"> Téléphone </label>
            <input id="userPhone" type="number" name="userPhone" class="inputForm" value="<?= isset($_SESSION['old_inputs']) ? $_SESSION['old_inputs']['userPhone'] : '' ?>">
        </section>

        <!-- Section de la ville du produit -->
        <section class="sectionInputCheckbox">
            <label for="userIsAdmin" class="labelName"> Is Admin ? </label>
            <input id="userIsAdmin" type="checkbox" name="userIsAdmin">
        </section>

        <p> * : Champs obligatoires. </p>

        <!-- Section du boutton valider -->
        <section class="sectionButtonCreate">
            <button type="submit" class="btnSubmit"> Valider </button>
        </section>

        <p style="color: white;"> Si vous voulez ajouter une adresse à cet utilisateur. Veuillez le faire via le formulaire du Front-Office. </p>

    </form>


</section>