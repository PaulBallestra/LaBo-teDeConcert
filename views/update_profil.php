<section>

    <section class="divContentUpdateProfilPage">

        <div class="divUpdateProfil">

            <div class="divProfilTitle">
                <h1 class="pageTitle"> Profil </h1>
            </div>

            <form action="index.php?page=profile&action=update_profile" method="post">

                <section class="sectionInput">
                    <!-- Nom de l'user -->
                    <label for="lastname" class="labelName"> Nom </label>
                    <input id="lastname" type="text" name="lastname" class="inputForm" value="<?= isset($_SESSION['old_inputs']['lastname']) ? $_SESSION['old_inputs']['lastname'] : (isset($_SESSION['user']) ? $_SESSION['user']['lastname'] : '') ?>">
                </section>

                <section class="sectionInput">
                    <!-- Prenom de l'user -->
                    <label for="firstname" class="labelName"> Prénom </label>
                    <input id="firstname" type="text" name="firstname" class="inputForm" value="<?= isset($_SESSION['old_inputs']['firstname']) ? $_SESSION['old_inputs']['firstname'] : (isset($_SESSION['user']) ? $_SESSION['user']['firstname'] : '') ?>">
                </section>

                <section class="sectionInput">
                    <!-- Email de l'user -->
                    <label for="email" class="labelName"> Email </label>
                    <input id="email" type="email" name="email" class="inputForm" value="<?= isset($_SESSION['old_inputs']['email']) ? $_SESSION['old_inputs']['email'] : (isset($_SESSION['user']) ? $_SESSION['user']['email'] : '') ?>">
                </section>

                <section class="sectionInput">
                    <!-- MDP de l'user -->
                    <label for="password" class="labelName"> Mot de passe </label>
                    <input id="password" type="password" name="password" class="inputForm">
                </section>

                <section class="sectionInput">
                    <!-- Téléphone de l'user -->
                    <label for="phone" class="labelName"> Téléphone </label>
                    <input id="phone" type="tel" name="phone" pattern="[0-9]{10}" class="inputForm" value="<?= isset($_SESSION['old_inputs']['phone']) ? $_SESSION['old_inputs']['phone'] : (isset($_SESSION['user']) ? $_SESSION['user']['phone'] : '') ?>">
                </section>

                <!-- Section du boutton valider -->
                <section class="sectionButtonSaveUpdateProfil">
                    <button type="submit" class="btnSubmit"> Sauvegarder Profil </button>
                </section>

            </form>

        </div>

        <!-- Separateur qui va separer les 2 parties de la page -->
        <div class="divSeparateurHR">
            <hr>
        </div>

        <div class="divUpdateAdresse">

            <div class="divProfilTitle">
                <h1 class="pageTitle"> Adresse </h1>
            </div>

            <form action="index.php?page=profile&action=update_address" method="post">

                <section class="sectionInput">
                    <!-- Numéro de l'user -->
                    <label for="addressNumber" class="labelName"> Numéro </label>
                    <input id="addressNumber" type="number" name="addressNumber" min="0" class="inputForm" value="<?= isset($_SESSION['old_inputs']['addressNumber']) ? $_SESSION['old_inputs']['addressNumber'] : (isset($_SESSION['user']['address']) ? $_SESSION['user']['address']['number'] : '') ?>">
                </section>

                <section class="sectionInput">
                    <!-- Rue de l'user -->
                    <label for="addressStreet" class="labelName"> Rue </label>
                    <input id="addressStreet" type="text" name="addressStreet" class="inputForm" value="<?= isset($_SESSION['old_inputs']['addressStreet']) ? $_SESSION['old_inputs']['addressStreet'] : (isset($_SESSION['user']['address']) ? $_SESSION['user']['address']['street'] : '') ?>">
                </section>

                <section class="sectionInput">
                    <!-- Ville -->
                    <label for="addressTown" class="labelName"> Ville </label>
                    <input id="addressTown" type="text" name="addressTown" class="inputForm" value="<?= isset($_SESSION['old_inputs']['addressTown']) ? $_SESSION['old_inputs']['addressTown'] : (isset($_SESSION['user']['address']) ? $_SESSION['user']['address']['town'] : '') ?>">
                </section>

                <section class="sectionInput">
                    <!-- Code postal -->
                    <label for="addressPostal" class="labelName"> Code Postal </label>
                    <input id="addressPostal" type="number" name="addressPostal" min="0" class="inputForm" value="<?= isset($_SESSION['old_inputs']['addressPostal']) ? $_SESSION['old_inputs']['addressPostal'] : (isset($_SESSION['user']['address']) ? $_SESSION['user']['address']['postal_code'] : '') ?>">
                </section>

                <section class="sectionInput">
                    <!-- Pays -->
                    <label for="addressCountry" class="labelName"> Pays </label>
                    <input id="addressCountry" type="text" name="addressCountry" class="inputForm" value="<?= isset($_SESSION['old_inputs']['addressCountry']) ? $_SESSION['old_inputs']['addressCountry'] : (isset($_SESSION['user']['address']) ? $_SESSION['user']['address']['country'] : '') ?>">
                </section>

                <!-- Section du boutton annuler -->
                <section class="sectionButtonCancelUpdateProfil">
                    <button type="submit" class="btnSubmit"> Sauvegarder Adresse </button>
                </section>

            </form>

        </div>

    </section>

</section>