<!-- Section avec le pin et l'accroche du site -->
<section class="sectionSearchPinAccueil">

    <div class="divPinAccueil">

        <form action="index.php?page=products&action=indexSearch" method="post">

            <section class="sectionInput">
                <!-- Prénom de l'user -->
                <label for="searchTown" class="labelName"> Ville </label>
                <input id="searchTown" type="text" name="searchTown" class="inputForm" value="Paris" required>
            </section>

            <section class="sectionInput">
                <!-- Prénom de l'user -->
                <label for="searchCapacity" class="labelName"> Capacités </label>
                <select id="searchCapacity" name="searchCapacity" class="inputFormSelect" required>

                    <option value="1" selected> 100 - 2500 </option>
                    <option value="2"> 2500 - 5000 </option>
                    <option value="3"> 5000 - 10000 </option>
                    <option value="4"> 10000 - 100000 </option>

                </select>
            </section>

            <section class="sectionInput">
                <!-- Prénom de l'user -->
                <label for="searchCategory" class="labelName"> Quel type de salle ? </label>
                <select id="searchCategory" name="searchCategory" class="inputFormSelect" required>

                    <?php foreach($categories as $category) : ?>
                        <option value="<?= $category['id'] ?>" selected> <?= $category['name'] ?> </option>
                    <?php endforeach; ?>

                </select>
            </section>

            <!-- Bouton submit qui va envoyer le formulaire -->
            <button type="submit" class="btnSubmit"> Rechercher </button>

        </form>

    </div>

    <div class="divAccrocheAccueil">

        <!-- Ici on affiche l'accroche personnalisée si il est connecté -->
        <h1 class="pageTitle"> <?= isset($_SESSION['is_connected']) && $_SESSION['is_connected'] == 1 ? $_SESSION['user']['firstname'] . ', d' : 'D'?>écouvrez votre future salle ! </h1>
        <h3 class="pageAccroche"> Pacourez les selon vos critères. </h3>

    </div>

</section>
