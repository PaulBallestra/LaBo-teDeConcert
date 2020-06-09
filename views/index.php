<!-- Section avec le pin et l'accroche du site -->
<section class="sectionSearchPinAccueil">

    <div class="divPinAccueil">

        <img class="imgPinAccueil" src="assets/images/BackPin.svg">

    </div>

    <div class="divAccrocheAccueil">

        <!-- Ici on affiche l'accroche personnalisée si il est connecté -->
        <h1 class="pageTitle"> <?= isset($_SESSION['is_connected']) && $_SESSION['is_connected'] == 1 ? $_SESSION['user']['firstname'] . ', d' : 'D'?>écouvrez votre future salle ! </h1>
        <h3 class="pageAccroche"> Pacourez les selon vos critères. </h3>

    </div>

</section>

<!-- Section du slider des catégories -->
<section class="sectionCategoriesAccueil">

    <div class="divSliderCategoriesAccueil">

        <h1 class="pageTitle"> Ou parcourez nos catégories </h1>

    </div>

</section>
