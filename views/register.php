<section class="mainAccroche">

    <h1 class="pageTitle"> Inscription </h1>
    <h3> Créez un compte et achetez votre première salle ! </h3>

</section>

<section class="mainFormulaire">

    <section class="emptySection"></section>

    <section class="sectionFormulaire">

        <!-- Formulaire d'inscription -->
        <form action="index.php?page=register&action=new" method="post">

            <section class="sectionInput">
                <!-- Nom de l'user -->
                <label for="lastname" class="labelName"> Nom * </label>
                <input id="lastname" type="text" name="lastname" class="inputForm" value="<?= isset($_SESSION['old_inputs']) ? $_SESSION['old_inputs']['lastname'] : '' ?>" required>
            </section>

            <section class="sectionInput">
                <!-- Prénom de l'user -->
                <label for="firstname" class="labelName"> Prénom * </label>
                <input id="firstname" type="text" name="firstname" class="inputForm" value="<?= isset($_SESSION['old_inputs']) ? $_SESSION['old_inputs']['firstname'] : '' ?>" required>
            </section>

            <section class="sectionInput">
                <!-- Email de l'user -->
                <label for="email" class="labelName"> Email * </label>
                <input id="email" type="email" name="email" class="inputForm" value="<?= isset($_SESSION['old_inputs']) ? $_SESSION['old_inputs']['email'] : '' ?>" required>
            </section>

            <section class="sectionInput">
                <!-- Mot de passe de l'user -->
                <label for="password" class="labelName"> Mot de passe * </label>
                <input id="password" type="password" name="password" class="inputForm" required>
            </section>

            <p> * : Champs obligatoires. </p>

            <!-- Bouton submit qui va envoyer le formulaire -->
            <button type="submit" class="btnSubmit"> S'inscrire </button>

            <a href="index.php?page=login"> <p>Vous avez déjà un compte ? Connectez-vous ! </p> </a>


        </form>

    </section>

    <section class="emptySection"></section>

</section>