<!-- Accroche de la page de connexion -->
<section class="mainAccroche">

    <h1 class="pageTitle"> Connexion </h1>
    <h3> Prêt a vous connecter ? </h3>

</section>

<!-- Contenu de la page de connexion -->
<section class="mainFormulaire">

    <!-- Section vide qui va permettre de centrer la section du formulaire -->
    <section class="emptySection"></section>

    <!-- Section du formulaire -->
    <section class="sectionFormulaire">

        <!-- Formulaire d'inscription -->
        <form action="index.php?page=login&action=connect" method="post">

            <section class="sectionInput">

                <!-- Email de l'user -->
                <label for="email" class="labelName"> Email * </label>
                <input id="email" type="email" name="email" class="inputForm" value="<?= !empty($_SESSION['old_inputs']) ? $_SESSION['old_inputs']['email'] : '' //affichage des ancienens valeurs si il y en a ?>" required>

            </section>

            <section class="sectionInput">

                <!-- Mot de passe de l'user -->
                <label for="password" class="labelName"> Mot de passe * </label>
                <input id="password" type="password" name="password" class="inputForm" required>

            </section>

            <p> * : Champs obligatoires. </p>

            <!-- Bouton submit qui va envoyer le formulaire -->
            <button type="submit" class="btnSubmit"> Connexion </button>

            <a href="index.php?page=register"> <p>Pas de compte ?  Créez en un ! </p> </a>

        </form>

    </section>

    <!-- Section vide qui va permettre de centrer la section du formulaire -->
    <section class="emptySection"></section>

</section>